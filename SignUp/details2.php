<?php
class details2 {
    private $details;
    private $viewDetails;

    public function __construct($conn) {
        $this->details = new Details($conn);
        $this->viewDetails = new viewDetails();
    }

    public function displayDetails() {
        $details = $this->details2->getDetails();
        $this->userView->displayDetails($details);
    }
}
?>