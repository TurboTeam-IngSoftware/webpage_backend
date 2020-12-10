<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.

if ( $_POST['payload'] ) {
shell_exec( ‘cd /public_html/webpage_backend/ && git reset –hard HEAD && git pull’ );
}

?>hi