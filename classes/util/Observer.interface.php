<?php

/**
 *  
 * Copyright Jan 30, 2012 5:27:32 PM Chris Keeley <info@chriskeeley.co.uk> All rights reserved. 
 *
 * This interface defines a type consistent with the methods required to 
 * play the role of the observer.
 *
 * @author chris
 */
interface Observer {
   /**
    * Register an object that we are interested in recieving
    * state updates from. 
    */
   public function observe($placeholder, UIView $view);
   /**
    * Retrieve state from all objects we are observing state on.
    */
   public function notify();
}
?>
