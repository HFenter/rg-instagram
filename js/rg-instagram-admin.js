// admin functions for grabbing thier hash and user id
jQuery(document).ready(function($) {
	var user_hash = window.location.hash,
        token = user_hash.substring(1),
        id = token.split('.')[0];
		//alert(user_hash);
    if(user_hash){
		$('#rg_ig_token').val(token);
		$('#rg_ig_userid').val(id);
        $('#rg_ig_get_token').append('<div><strong>Here is your access token and user id.  They have been filled in for you automatically.  <em>However make sure to hit "Save Changes" below, or they will not be saved!</em></strong><p><strong>Your Access Token:</strong> <input type="text" readonly value="'+token+'"><br><strong>Your User ID:</strong><input type="text" readonly value="'+id+'">.</div>');
    }
});