<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'MercadoPago\\PP\\Sdk\\Common\\AbstractCollection' => $baseDir . '/src/Common/AbstractCollection.php',
    'MercadoPago\\PP\\Sdk\\Common\\AbstractEntity' => $baseDir . '/src/Common/AbstractEntity.php',
    'MercadoPago\\PP\\Sdk\\Common\\Config' => $baseDir . '/src/Common/Config.php',
    'MercadoPago\\PP\\Sdk\\Common\\Constants' => $baseDir . '/src/Common/Constants.php',
    'MercadoPago\\PP\\Sdk\\Common\\Manager' => $baseDir . '/src/Common/Manager.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Notification\\Notification' => $baseDir . '/src/Entity/Notification/Notification.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Notification\\PaymentDetails' => $baseDir . '/src/Entity/Notification/PaymentDetails.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Notification\\PaymentDetailsList' => $baseDir . '/src/Entity/Notification/PaymentDetailsList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Notification\\Refund' => $baseDir . '/src/Entity/Notification/Refund.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Notification\\RefundList' => $baseDir . '/src/Entity/Notification/RefundList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\AdditionalInfo' => $baseDir . '/src/Entity/Payment/AdditionalInfo.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\AdditionalInfoPayer' => $baseDir . '/src/Entity/Payment/AdditionalInfoPayer.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\AdditionalInfoPayerAddress' => $baseDir . '/src/Entity/Payment/AdditionalInfoPayerAddress.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Address' => $baseDir . '/src/Entity/Payment/Address.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Item' => $baseDir . '/src/Entity/Payment/Item.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\ItemList' => $baseDir . '/src/Entity/Payment/ItemList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Payer' => $baseDir . '/src/Entity/Payment/Payer.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\PayerIdentification' => $baseDir . '/src/Entity/Payment/PayerIdentification.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Payment' => $baseDir . '/src/Entity/Payment/Payment.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Phone' => $baseDir . '/src/Entity/Payment/Phone.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\PointOfInteraction' => $baseDir . '/src/Entity/Payment/PointOfInteraction.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\ReceiverAddress' => $baseDir . '/src/Entity/Payment/ReceiverAddress.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Shipments' => $baseDir . '/src/Entity/Payment/Shipments.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Payment\\TransactionDetails' => $baseDir . '/src/Entity/Payment/TransactionDetails.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Address' => $baseDir . '/src/Entity/Preference/Address.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\BackUrl' => $baseDir . '/src/Entity/Preference/BackUrl.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\DifferentialPricing' => $baseDir . '/src/Entity/Preference/DifferentialPricing.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentMethod' => $baseDir . '/src/Entity/Preference/ExcludedPaymentMethod.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentMethodList' => $baseDir . '/src/Entity/Preference/ExcludedPaymentMethodList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentType' => $baseDir . '/src/Entity/Preference/ExcludedPaymentType.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentTypeList' => $baseDir . '/src/Entity/Preference/ExcludedPaymentTypeList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\FreeMethod' => $baseDir . '/src/Entity/Preference/FreeMethod.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\FreeMethodList' => $baseDir . '/src/Entity/Preference/FreeMethodList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Item' => $baseDir . '/src/Entity/Preference/Item.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ItemList' => $baseDir . '/src/Entity/Preference/ItemList.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Payer' => $baseDir . '/src/Entity/Preference/Payer.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\PayerIdentification' => $baseDir . '/src/Entity/Preference/PayerIdentification.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\PaymentMethod' => $baseDir . '/src/Entity/Preference/PaymentMethod.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Phone' => $baseDir . '/src/Entity/Preference/Phone.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Preference' => $baseDir . '/src/Entity/Preference/Preference.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ReceiverAddress' => $baseDir . '/src/Entity/Preference/ReceiverAddress.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Shipment' => $baseDir . '/src/Entity/Preference/Shipment.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Track' => $baseDir . '/src/Entity/Preference/Track.php',
    'MercadoPago\\PP\\Sdk\\Entity\\Preference\\TrackList' => $baseDir . '/src/Entity/Preference/TrackList.php',
    'MercadoPago\\PP\\Sdk\\HttpClient\\HttpClient' => $baseDir . '/src/HttpClient/HttpClient.php',
    'MercadoPago\\PP\\Sdk\\HttpClient\\HttpClientInterface' => $baseDir . '/src/HttpClient/HttpClientInterface.php',
    'MercadoPago\\PP\\Sdk\\HttpClient\\Requester\\CurlRequester' => $baseDir . '/src/HttpClient/Requester/CurlRequester.php',
    'MercadoPago\\PP\\Sdk\\HttpClient\\Requester\\RequesterInterface' => $baseDir . '/src/HttpClient/Requester/RequesterInterface.php',
    'MercadoPago\\PP\\Sdk\\HttpClient\\Response' => $baseDir . '/src/HttpClient/Response.php',
    'MercadoPago\\PP\\Sdk\\Sdk' => $baseDir . '/src/Sdk.php',
);
