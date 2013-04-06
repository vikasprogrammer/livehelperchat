<?php

class erLhcoreClassModelInstanceUser {

   public function getState()
   {
       return array(
               'id'              	=> $this->id,
               'user_id'            => $this->user_id,
               'instance_id'     	=> $this->instance_id
       );
   }

   public function setState( array $properties )
   {
       foreach ( $properties as $key => $val )
       {
           $this->$key = $val;
       }
   }

   public static function fetch($chat_id) {
       	 $chat = erLhcoreClassInstance::getSession()->load( 'erLhcoreClassModelInstanceUser', (int)$chat_id );
       	 return $chat;
   }

   public function saveThis() {
       	 erLhcoreClassInstance::getSession()->saveOrUpdate($this);
   }

   public function updateThis() {
       	 erLhcoreClassInstance::getSession()->update($this);
   }

   public function setIP()
   {
       $this->ip = $_SERVER['REMOTE_ADDR'];
   }

   public function __get($var) {

       switch ($var) {

       	case 'instance':
       		   try {
       		   		$this->instance = erLhcoreClassModelInstance::fetch($this->instance_id);
       		   } catch (Exception $e) {
       		   		$this->instance = false;
       		   }
       		   return $this->instance;
       		break;

       	default:
       		break;
       }

   }

   public static function getUserInstances($user_id) {
   		return erLhcoreClassInstance::getList(array('filter' => array('user_id' => $user_id)),'erLhcoreClassModelInstanceUser','lh_instance_user');
   }

   public static function getUserInstancesCached($userID = false) {
   		if (isset($GLOBALS['lhCacheUserInstances_'.$userID])) return $GLOBALS['lhCacheUserInstances_'.$userID];
	   	if (isset($_SESSION['lhCacheUserInstances_'.$userID])) return $_SESSION['lhCacheUserInstances_'.$userID];

	   	$db = ezcDbInstance::get();

	   	if ($userID === false)
	   	{
	   		$currentUser = erLhcoreClassUser::instance();
	   		$userID = $currentUser->getUserID();
	   	}

	   	$stmt = $db->prepare('SELECT lh_instance_user.instance_id FROM lh_instance_user WHERE user_id = :user_id ORDER BY id ASC');
	   	$stmt->bindValue( ':user_id',$userID);
	   	$stmt->execute();
	   	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	   	$idArray = array();

	   	foreach ($rows as $row)
	   	{
	   		$idArray[] = $row['instance_id'];
	   	}

	   	$GLOBALS['lhCacheUserInstances_'.$userID] = $idArray;
	   	$_SESSION['lhCacheUserInstances_'.$userID] = $idArray;

	   	return $idArray;
   }

   public static function isInstanceOperator($instance, $currentUser) {

   		if ($currentUser->all_instances == 1) {
   			return true;
   		}

   		return in_array($instance, self::getUserInstancesCached($currentUser->id));
   }

   public static function removeInstanceFromUser($instance, $user_id) {
	   	$session = erLhcoreClassInstance::getSession();
	   	$q = $session->database->createDeleteQuery();
	   	$q->deleteFrom( 'lh_instance_user' )
	   	->where( $q->expr->eq( 'user_id', $q->bindValue( $user_id ) ),$q->expr->eq( 'instance_id', $q->bindValue( $instance ) ) );
	   	$stmt = $q->prepare();
	   	$stmt->execute();

	   	if (isset($_SESSION['lhCacheUserInstances_'.$user_id])){
	   		unset($_SESSION['lhCacheUserInstances_'.$user_id]);
	   	}
   }

   public static function removeInstancesFromUser ( $user_id ) {
	   	$session = erLhcoreClassInstance::getSession();
	   	$q = $session->database->createDeleteQuery();
	   	$q->deleteFrom( 'lh_instance_user' )
	   	->where( $q->expr->eq( 'user_id', $q->bindValue( $user_id ) ) );
	   	$stmt = $q->prepare();
	   	$stmt->execute();

	   	if (isset($_SESSION['lhCacheUserInstances_'.$user_id])){
	   		unset($_SESSION['lhCacheUserInstances_'.$user_id]);
	   	}
   }

   public $id = null;
   public $user_id = null;
   public $instance_id = null;
}

?>