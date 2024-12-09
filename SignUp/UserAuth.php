<?php
class UserAuth {
    private $db;
    private $emailService;

    public function __construct(Database $db, EmailService $emailService) {
        $this->db = $db;
        $this->emailService = $emailService;
    }

    public function login($email, $password) {
        $user = $this->db->query("SELECT * FROM signup WHERE email = :email", [':email' => $email])->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Generate OTP
            $otp = rand(100000, 999999);
            $otp_expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            // Save OTP in the database
            $this->db->query("UPDATE signup SET otp = :otp, otp_expiry = :otp_expiry WHERE id = :id", [
                ':otp' => $otp,
                ':otp_expiry' => $otp_expiry,
                ':id' => $user['id']
            ]);

            // Send OTP via email
            $subject = "Your OTP for Login";
            $body = "
                <h1>Login Verification</h1>
                <p>Your OTP is: <strong>$otp</strong></p>
                <p>This OTP is valid for 5 minutes.</p>
            ";
            $this->emailService->sendEmail($user['email'], $subject, $body);

            // Save temporary session
            $_SESSION['temp_user'] = ['id' => $user['id'], 'email' => $user['email']];
            return true;
        }

        return false;
    }

    public function verifyOTP($otp) {
        if (!isset($_SESSION['temp_user'])) {
            throw new Exception("No user session found.");
        }

        $userId = $_SESSION['temp_user']['id'];
        $user = $this->db->query("SELECT * FROM signup WHERE id = :id AND otp = :otp", [
            ':id' => $userId,
            ':otp' => $otp
        ])->fetch();

        if ($user) {
            if (strtotime($user['otp_expiry']) >= time()) {
                // OTP is valid, log the user in
                $_SESSION['user_id'] = $user['id'];
                unset($_SESSION['temp_user']);
                return true;
            } else {
                throw new Exception("OTP has expired. Please log in again.");
            }
        }

        throw new Exception("Invalid OTP. Please try again.");
    }
}
?>
