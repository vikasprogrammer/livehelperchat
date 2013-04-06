<?php

class erLhcoreClassUserDep {

   function __construct()
   {

   }

   public static function getUserDepartaments($userID = false)
   {

         if (isset($GLOBALS['lhCacheUserDepartaments_'.$userID])) return $GLOBALS['lhCacheUserDepartaments_'.$userID];
         if (isset($_SESSION['lhCacheUserDepartaments_'.$userID])) return $_SESSION['lhCacheUserDepartaments_'.$userID];


         $db = ezcDbInstance::get();

         if ($userID === false)
         {
             $currentUser = erLhcoreClassUser::instance();
             $userID = $currentUser->getUserID();
         }

         $stmt = $db->prepare('SELECT lh_userdep.dep_id FROM lh_userdep WHERE user_id = :user_id ORDER BY id ASC');
         $stmt->bindValue( ':user_id',$userID);
         $stmt->execute();
         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

         $idArray = array();

         foreach ($rows as $row)
         {
             $idArray[] = $row['dep_id'];
         }

         $GLOBALS['lhCacheUserDepartaments_'.$userID] = $idArray;
         $_SESSION['lhCacheUserDepartaments_'.$userID] = $idArray;

         return $idArray;
   }

   public static function getDefaultUserDepartment() {
   		return array_shift(self::getUserDepartaments());
   }

   public static function addUserDepartament($department_id, $userID = false, $UserData = false)
   {
	   	$db = ezcDbInstance::get();

	   	if ($userID === false)
	   	{
	   		$currentUser = erLhcoreClassUser::instance();
	   		$userID = $currentUser->getUserID();
	   	}

	   	if ($department_id > 0){
		   	$instanceUser = new erLhcoreClassModelUserDep();
		   	$instanceUser->dep_id = $department_id;
		   	$instanceUser->user_id = $userID;
		   	$instanceUser->hide_online = $UserData->hide_online;
		   	$instanceUser->saveThis();
	   	} else {

	   		foreach (erLhcoreClassModelInstanceUser::getUserInstancesCached($userID) as $instanceID) {
	   			$instanceUser = new erLhcoreClassModelUserDep();
	   			$instanceUser->dep_id = 0;
	   			$instanceUser->instance_id = $instanceID;
	   			$instanceUser->user_id = $userID;
	   			$instanceUser->hide_online = $UserData->hide_online;
	   			$instanceUser->saveThis();
	   		}

	   		if ($UserData->all_instances) {
	   			$instanceUser = new erLhcoreClassModelUserDep();
	   			$instanceUser->dep_id = 0;
	   			$instanceUser->instance_id = 0;
	   			$instanceUser->user_id = $userID;
	   			$instanceUser->hide_online = $UserData->hide_online;
	   			$instanceUser->saveThis();
	   		}
	   	}

	   	if (isset($_SESSION['lhCacheUserDepartaments_'.$userID])){
	   		unset($_SESSION['lhCacheUserDepartaments_'.$userID]);
	   	}
   }

   public static function deleteUserDepartament($department_id, $userID = false)
   {
	   	$db = ezcDbInstance::get();
	   	$stmt = $db->prepare('DELETE FROM lh_userdep WHERE user_id = :user_id AND dep_id = :dep_id');
	   	$stmt->bindValue( ':user_id',$userID);
	   	$stmt->bindValue( ':dep_id',$department_id);
	   	$stmt->execute();

	   	if (isset($_SESSION['lhCacheUserDepartaments_'.$userID])){
	   		unset($_SESSION['lhCacheUserDepartaments_'.$userID]);
	   	}
   }

   public static function addUserDepartaments($Departaments, $userID = false,$UserData = false)
   {
       $db = ezcDbInstance::get();
       if ($userID === false)
       {
           $currentUser = erLhcoreClassUser::instance();
           $userID = $currentUser->getUserID();
       }

       $stmt = $db->prepare('DELETE FROM lh_userdep WHERE user_id = :user_id');
       $stmt->bindValue( ':user_id',$userID);
       $stmt->execute();

       foreach ($Departaments as $DepartamentID)
       {
            $stmt = $db->prepare('INSERT INTO lh_userdep (user_id,dep_id,hide_online) VALUES (:user_id,:dep_id,:hide_online)');
            $stmt->bindValue( ':user_id',$userID);
            $stmt->bindValue( ':dep_id',$DepartamentID);
            $stmt->bindValue( ':hide_online',$UserData->hide_online);
            $stmt->execute();
       }

       if (isset($_SESSION['lhCacheUserDepartaments_'.$userID])){
           unset($_SESSION['lhCacheUserDepartaments_'.$userID]);
       }

   }


   public static function canMoveToDepartment($department, $user_id) {

	   	$limitation = erLhcoreClassChat::getInstanceLimitation('lh_departament',$user_id);
	   	$filterArray = array();

	   	// Does not have any assigned department
	   	if ($limitation === false) {
	   		$filterArray['filter']['instance_id'] = -1;
	   	} elseif ($limitation !== true) {
	   		$filterArray['customfilter'][] = $limitation.' OR instance_id = 0';
	   	}

	   	$filterArray['filter']['id'] = $department;

	   	return erLhcoreClassModelDepartament::getCount($filterArray) > 0;
   }

   public static function setHideOnlineStatus($UserData) {
       $db = ezcDbInstance::get();
       $stmt = $db->prepare('UPDATE lh_userdep SET hide_online = :hide_online WHERE user_id = :user_id');
       $stmt->bindValue( ':hide_online',$UserData->hide_online);
       $stmt->bindValue( ':user_id',$UserData->id);
       $stmt->execute();
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