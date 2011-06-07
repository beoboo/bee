<?php

/**
 * BaseDeal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $deal_type_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property float $price
 * @property float $discount
 * @property timestamp $published_at
 * @property timestamp $start_at
 * @property timestamp $end_at
 * @property Company $Company
 * @property DealType $DealType
 * @property Doctrine_Collection $Coupons
 * @property Doctrine_Collection $FavoriteCompanies
 * 
 * @method integer             getCompanyId()         Returns the current record's "company_id" value
 * @method integer             getDealTypeId()        Returns the current record's "deal_type_id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method string              getDescription()       Returns the current record's "description" value
 * @method string              getImage()             Returns the current record's "image" value
 * @method float               getPrice()             Returns the current record's "price" value
 * @method float               getDiscount()          Returns the current record's "discount" value
 * @method timestamp           getPublishedAt()       Returns the current record's "published_at" value
 * @method timestamp           getStartAt()           Returns the current record's "start_at" value
 * @method timestamp           getEndAt()             Returns the current record's "end_at" value
 * @method Company             getCompany()           Returns the current record's "Company" value
 * @method DealType            getDealType()          Returns the current record's "DealType" value
 * @method Doctrine_Collection getCoupons()           Returns the current record's "Coupons" collection
 * @method Doctrine_Collection getFavoriteCompanies() Returns the current record's "FavoriteCompanies" collection
 * @method Deal                setCompanyId()         Sets the current record's "company_id" value
 * @method Deal                setDealTypeId()        Sets the current record's "deal_type_id" value
 * @method Deal                setName()              Sets the current record's "name" value
 * @method Deal                setDescription()       Sets the current record's "description" value
 * @method Deal                setImage()             Sets the current record's "image" value
 * @method Deal                setPrice()             Sets the current record's "price" value
 * @method Deal                setDiscount()          Sets the current record's "discount" value
 * @method Deal                setPublishedAt()       Sets the current record's "published_at" value
 * @method Deal                setStartAt()           Sets the current record's "start_at" value
 * @method Deal                setEndAt()             Sets the current record's "end_at" value
 * @method Deal                setCompany()           Sets the current record's "Company" value
 * @method Deal                setDealType()          Sets the current record's "DealType" value
 * @method Deal                setCoupons()           Sets the current record's "Coupons" collection
 * @method Deal                setFavoriteCompanies() Sets the current record's "FavoriteCompanies" collection
 * 
 * @package    findeal
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseDeal extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('deal');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('deal_type_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('image', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('price', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             ));
        $this->hasColumn('discount', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             ));
        $this->hasColumn('published_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('start_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('end_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id'));

        $this->hasOne('DealType', array(
             'local' => 'deal_type_id',
             'foreign' => 'id'));

        $this->hasMany('Coupon as Coupons', array(
             'local' => 'id',
             'foreign' => 'deal_id'));

        $this->hasMany('FavoriteCompany as FavoriteCompanies', array(
             'local' => 'id',
             'foreign' => 'deal_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}