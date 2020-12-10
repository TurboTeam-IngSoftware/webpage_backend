<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.

if ( $_POST['PAYLOAD'] ) {
shell_exec( 'git reset –hard HEAD && git pull' );
echo 'pull performed';
}
shell_exec( 'git reset –hard HEAD && git pull' );
echo 'pull performed';

?>hi