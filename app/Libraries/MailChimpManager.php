<?php
namespace App\Libraries;

class MailChimpManager
{
    public function getEmailsList($listId)
    {
        $emails = [];
        $apiKey = 'YOUR_API_KEY';
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1); // Extract data center from API key

        // Mailchimp API URL for listing members
        $url = "https://$dataCenter.api.mailchimp.com/3.0/lists/$listId/members";

        // Initialize cURL
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: apikey ' . $apiKey,
        ]);

        // Execute cURL request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL
        curl_close($ch);

        // Handle the response
        if ($httpCode == 200) 
        {
            $data = json_decode($response, true);
            if (isset($data['members']) && sizeof($data['members']) > 0) 
            {
                foreach ($data['members'] as $member) 
                {
                    $emails[] = $member['email_address'];
                }
            } 
        } 

        return $emails;
    }
}
?>