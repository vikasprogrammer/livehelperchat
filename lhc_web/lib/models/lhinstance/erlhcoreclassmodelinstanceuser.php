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

   public static function removeInstanceFromUser($instance, $user_id) {
	   	$session = erLhcoreClassInstance::getSession();
	   	$q = $session->database->createDeleteQuery();
	   	$q->deleteFrom( 'lh_instance_user' )
	   	->where( $q->expr->eq( 'user_id', $q->bindValue( $user_id ) ),$q->expr->eq( 'instance_id', $q->bindValue( $instance ) ) );
	   	$stmt = $q->prepare();
	   	$stmt->execute();
   }

   public static function removeInstancesFromUser ( $user_id ) {
	   	$session = erLhcoreClassInstance::getSession();
	   	$q = $session->database->createDeleteQuery();
	   	$q->deleteFrom( 'lh_instance_user' )
	   	->where( $q->expr->eq( 'user_id', $q->bindValue( $user_id ) ) );
	   	$stmt = $q->prepare();
	   	$stmt->execute();
   }

   public $id = null;
   public $user_id = null;
   public $instance_id = null;
}

?>