var apiKey = '';
var sessionId = '';
var token = '';

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

function getSQLcdet(SQLc_user_id,SQLc_key,SQLc_path,SQLc_session_id){

var formData = {SQLc_user_id:SQLc_user_id,SQLc_key:SQLc_key,SQLc_session_id:SQLc_session_id};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: SQLc_path+"validateReq.php",
		success: function(data){
		// $("#message").html(data);
			var val=JSON.parse(data.trim());
			apiKey = val.apiKey;
                        sessionId = val.sessionId;
                        token = val.token;
                        $('#spinner').css('display','none');
                        // (optional) add server code here
                        initializeSession();

			},
		error: function(xhr,status,strErr){
			//alert(status);
			 $('#spinner').css('display','none');
			}	
		});
	
}


function initializeSession() {
  var session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function(event) {
    session.subscribe(event.stream, 'subscriber', {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    }, handleError);
  });

  // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, initialize a publisher and publish to the session
    if (error) {
      handleError(error);
    } else {
      session.publish(publisher, handleError);
    }
  });
}
