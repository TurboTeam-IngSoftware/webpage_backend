<?php
if ( $_POST['payload'] ) {
shell_exec( 'git pull' );
echo 'pull performed';
}
?>