<?php

/**
 * BaseCoupon
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $deal_id
 * @property integer $user_id
 * @property timestamp $issued_at
 * @property timestamp $espires_at
 * @property string $offer_code
 * @property string $validation_code
 * @property timestamp $validate_at
 * @property Deal $Deal
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Feedbacks
 * 
 * @method integer             getDealId()          Returns the current record's "deal_id" value
 * @method integer             getUserId()          Returns the current record's "user_id" value
 * @method timestamp           getIssuedAt()        Returns the current record's "issued_at" value
 * @method timestamp           getEspiresAt()       Returns the current record's "espires_at" value
 * @method string              getOfferCode()       Returns the current record's "offer_code" value
 * @method string              getValidationCode()  Returns the current record's "validation_code" value
 * @method timestamp           getValidateAt()      Returns the current record's "validate_at" value
 * @method Deal                getDeal()            Returns the current record's "Deal" value
 * @method sfGuardUser         getUser()            Returns the current record's "User" value
 * @method Doctrine_Collection getFeedbacks()       Returns the current record's "Feedbacks" collection
 * @method Coupon              setDealId()          Sets the current record's "deal_id" value
 * @method Coupon              setUserId()          Sets the current record's "user_id" value
 * @method Coupon              setIssuedAt()        Sets the current record's "issued_at" value
 * @method Coupon              setEspiresAt()       Sets the current record's "espires_at" value
 * @method Coupon              setOfferCode()       Sets the current record's "offer_code" value
 * @method Coupon              setValidationCode()  Sets the current record's "validation_code" value
 * @method Coupon              setValidateAt()      Sets the current record's "validate_at" value
 * @method Coupon              setDeal()            Sets the current record's "Deal" value
 * @method Coupon              setUser()            Sets the current record's "User" value
 * @method Coupon              setFeedbacks()       Sets the current record's "Feedbacks" collection
 * 
 * @package    findeal
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseCoupon extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('coupon');
        $this->hasColumn('deal_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('issued_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('espires_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('offer_code', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('validation_code', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('validate_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Deal', array(
             'local' => 'deal_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('Feedback as Feedbacks', array(
             'local' => 'id',
             'foreign' => 'coupon_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}