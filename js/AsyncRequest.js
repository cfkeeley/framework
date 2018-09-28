/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var AsyncRequest = Class.create( {
   /**
    * Setup the listener for the async:connect event
    */
   initialize: function( ) {
       // we attach listener to the document object so that we have scope to listen for all events
       Event.observe(document, 'async:connection', this.makeRequest.bindAsEventListener(this));
   },
   /**
    * Make a request to the server
    * @param event the event object
    */
   makeRequest: function(event) {
       alert('Requesting...');
   }
});
/**
 * Setup the instance 
 */
document.observe('dom:loaded', function(event) {
   var asyncHandler = new AsyncRequest();
})

