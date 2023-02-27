<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v11/common/ad_type_infos.proto

namespace Google\Ads\GoogleAds\V11\Common;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A Smart campaign ad.
 *
 * Generated from protobuf message <code>google.ads.googleads.v11.common.SmartCampaignAdInfo</code>
 */
class SmartCampaignAdInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * List of text assets for headlines. When the ad serves the headlines will
     * be selected from this list. 3 headlines must be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v11.common.AdTextAsset headlines = 1;</code>
     */
    private $headlines;
    /**
     * List of text assets for descriptions. When the ad serves the descriptions
     * will be selected from this list. 2 descriptions must be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v11.common.AdTextAsset descriptions = 2;</code>
     */
    private $descriptions;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Ads\GoogleAds\V11\Common\AdTextAsset[]|\Google\Protobuf\Internal\RepeatedField $headlines
     *           List of text assets for headlines. When the ad serves the headlines will
     *           be selected from this list. 3 headlines must be specified.
     *     @type \Google\Ads\GoogleAds\V11\Common\AdTextAsset[]|\Google\Protobuf\Internal\RepeatedField $descriptions
     *           List of text assets for descriptions. When the ad serves the descriptions
     *           will be selected from this list. 2 descriptions must be specified.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V11\Common\AdTypeInfos::initOnce();
        parent::__construct($data);
    }

    /**
     * List of text assets for headlines. When the ad serves the headlines will
     * be selected from this list. 3 headlines must be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v11.common.AdTextAsset headlines = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getHeadlines()
    {
        return $this->headlines;
    }

    /**
     * List of text assets for headlines. When the ad serves the headlines will
     * be selected from this list. 3 headlines must be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v11.common.AdTextAsset headlines = 1;</code>
     * @param \Google\Ads\GoogleAds\V11\Common\AdTextAsset[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setHeadlines($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V11\Common\AdTextAsset::class);
        $this->headlines = $arr;

        return $this;
    }

    /**
     * List of text assets for descriptions. When the ad serves the descriptions
     * will be selected from this list. 2 descriptions must be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v11.common.AdTextAsset descriptions = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * List of text assets for descriptions. When the ad serves the descriptions
     * will be selected from this list. 2 descriptions must be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v11.common.AdTextAsset descriptions = 2;</code>
     * @param \Google\Ads\GoogleAds\V11\Common\AdTextAsset[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDescriptions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V11\Common\AdTextAsset::class);
        $this->descriptions = $arr;

        return $this;
    }

}
