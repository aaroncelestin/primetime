<?php
namespace Primetime;
require __DIR__ . '/src/functions.php';


view('content-header');


view('primetime-logo');
?>
<html>
	<div class="Ptusermgmt-container">
		<div class="page-header">
			<span class="login-signup"><a href="logout.php">Logout</a></span>
		</div>
		<div class="page-content">Welcome <?php echo $username;?></div>
	</div>

	TODO: Menu of forms needed, upcoming appointments, and changes


<html>
<?php view('footer') ?> 
