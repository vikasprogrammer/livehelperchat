<?php

class erLhcoreClassDepartament{



   function __construct()
   {

   }

   public static function getDepartaments()
   {
   		 $limitationSQL = '';

	   	 // Instances limitation
	   	 $limitation = erLhcoreClassChat::getInstanceLimitation('lh_departament');

	   	 // Does not have any assigned instance
	   	 if ($limitation === false) { return array(); }

	   	 if ($limitation !== true) {
	   		$limitationSQL = ' WHERE '.$limitation;
	   	 }

         $db = ezcDbInstance::get();
         $stmt = $db->prepare("SELECT * FROM lh_departament {$limitationSQL} ORDER BY id ASC");
         $stmt->execute();
         $rows = $stmt->fetchAll();

         return $rows;
   }

   public static function getDepartamentsStartChat($instance_id = false, $returnIDs = false)
   {
   		 $instanceCondition = '';
   		 if ( $instance_id !== false && is_numeric($instance_id) && $instance_id > 0 ) {
   		 	$instanceCondition = ' OR instance_id = :instance_id';
   		 }

   		 $db = ezcDbInstance::get();
         $stmt = $db->prepare("SELECT * FROM lh_departament WHERE instance_id = 0 {$instanceCondition} ORDER BY instance_id DESC");

         if ( $instance_id !== false && is_numeric($instance_id) && $instance_id > 0 ) {
         	$stmt->bindValue(':instance_id',$instance_id);
         }

         $stmt->execute();
         $rows = $stmt->fetchAll();

         if ($returnIDs == true) {
         	$ids = array();
         	foreach ($rows as $row) {
         		$ids[] = $row['id'];
         	}
         	return $ids;
         }

         return $rows;
   }



   public static function getSession()
   {
        if ( !isset( self::$persistentSession ) )
        {
            self::$persistentSession = new ezcPersistentSession(
                ezcDbInstance::get(),
                new ezcPersistentCodeManager( './pos/lhdepartament' )
            );
        }
        return self::$persistentSession;
   }

   private static $persistentSession;

}


?>