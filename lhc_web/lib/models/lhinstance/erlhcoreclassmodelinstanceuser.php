<?php

class erLhcoreClassModelChatInstanceUser {

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
       	 $chat = erLhcoreClassChat::getSession()->load( 'erLhcoreClassModelChatInstanceUser', (int)$chat_id );
       	 return $chat;
   }

   public function saveThis() {
       	 erLhcoreClassChat::getSession()->saveOrUpdate($this);
   }

   public function updateThis() {
       	 erLhcoreClassChat::getSession()->update($this);
   }

   public function setIP()
   {
       $this->ip = $_SERVER['REMOTE_ADDR'];
   }

   public function __get($var) {

       switch ($var) {

       	case 'is_operator_typing':
       		   $this->is_operator_typing = $this->operator_typing > (time()-6); // typing is considered if status did not changed for 10 seconds
       		   return $this->is_operator_typing;
       		break;

       	default:
       		break;
       }

   }

   public $id = null;
   public $user_id = null;
   public $instance_id = null;
}

?>