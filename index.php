<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    
    // Parse the main XML data
    $xml = simplexml_load_string($rawData);
    
    // Check if "ActivationInfoXml" exists in the main XML
    if (isset($xml->ActivationInfoXml)) {
        // Base64 decode the nested XML string
        $nestedXmlStr = base64_decode((string)$xml->ActivationInfoXml);
        
        // Save the decoded ActivationInfoXml to a .plist file
        file_put_contents('ActivationInfo.plist', $nestedXmlStr);
        
        // Parse the nested XML
        $nestedXml = simplexml_load_string($nestedXmlStr);
        
        // Check if the "SerialNumber" key exists in the nested XML
        if (isset($nestedXml->SerialNumber)) {
            // Get the value of "SerialNumber"
            $serialNumber = (string)$nestedXml->SerialNumber;
            
            // Save the SerialNumber to a text file
            file_put_contents('serial_numbers.txt', $serialNumber . PHP_EOL, FILE_APPEND);
            
            echo "SerialNumber and ActivationInfoXml saved.";
        } else {
            echo "SerialNumber not found in nested XML.";
        }
    } else {
        echo "ActivationInfoXml not found in main XML.";
    }
} else {
    echo "This script only accepts POST requests.";
}
?>
