<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version1 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('sf_guard_user_profile', 'mobile_number', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('sf_guard_user_profile', 'mobile_number');
    }
}