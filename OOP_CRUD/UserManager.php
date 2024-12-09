<?php
class UserManager {
    private $dbName;
    private $emailService;

    public function __construct(Connection $dbName, EmailService $emailService) {
        $this->dbName = $dbName;
        $this->emailService = $emailService;
    }

    // Create User
    public function createUser($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->db->query("INSERT INTO users (email, password) VALUES (:email, :password)", [
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }

    // Read User
    public function getUserById($user_id) {
        return $this->dbName->query("SELECT * FROM users WHERE user_id = :user_id", [':user_id' => $user_id])->fetch();
    }

    // Update User
    public function updateUser($user_id, $email) {
        $this->db->query("UPDATE users SET email = :email WHERE user_id = :user_id", [
            ':user_id' => $user_id,
            ':email' => $email
        ]);
    }

    // Delete User
    public function deleteUser($user_id) {
        $this->dbName->query("DELETE FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
    }

    // Reset Password with 2FA
    public function resetPassword($email) {
        $user = $this->dbName->query("SELECT * FROM users WHERE email = :email", [':email' => $email])->fetch();

        if ($user) {
            $otp = rand(100000, 999999);
            $otpExpiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            // Save OTP
            $this->dbName->query("UPDATE users SET otp = :otp, otpExpiry = :otpExpiry WHERE user_id = :user_id", [
                ':otp' => $otp,
                ':otp_expiry' => $otpExpiry,
                ':user_id' => $user['user_id']
            ]);

            // Send Email
            $subject = "Password Reset OTP";
            $body = "
                <p>Your OTP for password reset is: <strong>$otp</strong></p>
                <p>This OTP is valid for 5 minutes.</p>
            ";
            $this->emailService->sendEmail($user['email'], $subject, $body);
        }
    }

    public function verifyAndUpdatePassword($email, $otp, $newPassword) {
        $user = $this->dbName->query("SELECT * FROM users WHERE email = :email AND otp = :otp", [
            ':email' => $email,
            ':otp' => $otp
        ])->fetch();

        if ($user && strtotime($user['otp_expiry']) >= time()) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $this->db->query("UPDATE users SET password = :password, otp = NULL, otpExpiry = NULL WHERE user_id = :user_id", [
                ':password' => $hashedPassword,
                ':user_id' => $user['user_id']
            ]);
            return true;
        }
        return false;
    }
}
?>
