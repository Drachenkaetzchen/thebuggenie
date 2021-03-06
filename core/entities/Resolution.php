<?php

    namespace thebuggenie\core\entities;

    /**
     * @method static Resolution getByKeyish($key)
     * @Table(name="\thebuggenie\core\entities\tables\ListTypes")
     */
    class Resolution extends Datatype
    {

        const ITEMTYPE = Datatype::RESOLUTION;

        protected static $_items = null;

        protected $_key = null;
        
        protected $_itemtype = Datatype::RESOLUTION;

        public static function loadFixtures(Scope $scope)
        {
            foreach (array("CAN'T REPRODUCE", "WON'T FIX", "NOT AN ISSUE", "POSTPONED", "RESOLVED", "CAN'T FIX", "DUPLICATE") as $name)
            {
                $resolution = new Resolution();
                $resolution->setName($name);
                $resolution->setItemdata('');
                $resolution->setScope($scope);
                $resolution->save();
            }
        }

    }
