<?php
class viewDetails{
    public function displayDetails($details) {
        ?>
        <h2>User Details</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
            </tr>
            <?php foreach ($details as $details) { ?>
                <tr>
                    <td><?php echo $user->getId(); ?></td>
                    <td><?php echo $user->getEmail(); ?></td>
                </tr>
            <?php } ?>
        </table>
        <?php
    }
}
?>