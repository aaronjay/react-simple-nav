<?php

include "header.php";

echo <<< EOF

<div id="root" />
    <div class="container" style="height: 400px; padding-top: 20px;">			 
		<div class="row justify-content-center">
		    <h1>Loading...</h1>
		</div>
	</div>
</div>

EOF;

$footerScripts = '<script type="text/babel" src="/app-js.php"></script>';

include "footer.php";

?>