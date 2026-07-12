<?php
/**
 * Job Entity Class - Represents a job posting
 */

class Job
{
    private $data;
    
    /**
     * Constructor
     * @param array $data Job data from database
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    /**
     * Magic getter for job properties
     * @param string $key Property name
     * @return mixed Property value
     */
    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }
    
    /**
     * Get days remaining until closing date
     * @return int Number of days
     */
    public function daysToClose()
    {
        $closing = new DateTime($this->closingDate);
        $today = new DateTime();
        return ($closing > $today) ? $today->diff($closing)->days : 0;
    }
    
    /**
     * Get CSS class for urgency badge
     * @return string urgent, warning, or normal
     */
    public function getUrgencyClass()
    {
        $days = $this->daysToClose();
        if ($days <= 3 && $days > 0) return 'urgent';
        if ($days <= 7 && $days > 0) return 'warning';
        return 'normal';
    }
    
    /**
     * Get human-readable closing message
     * @return string
     */
    public function getClosingMessage()
    {
        $days = $this->daysToClose();
        if ($days === 0) return 'Closes today';
        if ($days === 1) return 'Closes tomorrow';
        if ($days <= 3) return "Closes in $days days - hurry";
        if ($days <= 7) return "Closes in $days days";
        return "Closing date: " . date('d M Y', strtotime($this->closingDate));
    }
}