<?php

function createConfig($version, $name) {
	$config = <<< EOT
<?php
define('PLX_CONFIG_PATH', '$name/configuration/');
?>
EOT;
	file_put_contents("PluXml-$version/config.php", $config);
}

/* ***** phpinfo * ****** */
if(!empty($_GET['phpinfo'])) {
	phpinfo();
	exit;
}
/* ***** changement de site ****** */
if(!empty($_GET['site'])) {
	list($version, $name) = explode('/', $_GET['site']);
	createConfig($version, $name);
	header('Location: PluXml-'.$version);
	exit;
}

/* **** nouveau site ******* */
if(!empty($_GET['pluxml-version'] and !empty($_GET['new-site']))) {
	$name = trim($_GET['new-site']);
	if(!empty($name) and ($name != 'data')) {
		$version = $_GET['pluxml-version'];
		createConfig($version, $name);
		header('Location: PluXml-'.$version);
		exit;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>PluXml multi-versions</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<style type="text/css">
		body { background: aliceBlue; }
		a { text-decoration: none; }
		a:hover { background-color: green; color: #fff; }
		h1 { text-align: center; width: 50%; margin: 0 auto; }
		.flex { display: flex; justify-content: center; }
		.center { text-align: center; }
		#new-site { max-width: 150px; }
		#main div { background-color: #fff; }
		@media screen and (min-width: 710px) {
			#main { display: flex; justify-content: center; }
			#main div { min-width: 350px; border: 1px solid #ced3ea; padding: 0.3rem; margin: auto 5px; box-shadow: 5px 5px 3px #a5d6e6; }
		}
	</style>
</head>
<body>
<div class="flex">
	<div>
		<a href="http://www.pluxml.org" target="_blank"><img src="img/pluxml.png" alt="PluXml" /></a>
	</div>
	<div class="center">
		<h1>PHP <?php echo phpversion(); ?></h1>
		<p><a href="index.php?phpinfo=1"  target="_blank">phpinfo</a></p>
	</div>
	<div>
		<a href="http://www.docker.com" target="blank"><img src="img/docker.png" alt="Docker" /></a>
	</div>
</div>
<div id="main">
	<div>
		<h2>PluXml multi-versions</h2>
		<ul>
<?php
foreach(glob('PluXml-*', GLOB_MARK + GLOB_ONLYDIR) as $item) {
	echo <<< ENTRY
			<li><a href="$item">$item</a></li>

ENTRY;
}
?>
		</ul>
<?php
$sites = array_map(
	function($item) {
		return str_replace('/configuration/parametres.xml', '', $item);
	},
	glob('PluXml-*/*/configuration/parametres.xml')
);
if(!empty($sites)) {
?>
		<h2>Sites disponibles</h2>
		<ul>
<?php
	foreach($sites as $site) {
		$href = 'index.php?site='.urlencode(preg_replace('@^PluXml-@', '', $site));
		echo <<< EOT
			<li><a href="$href">$site</a></li>

EOT;
	}
?>
		</ul>
<?php
}
?>
		<h2>Nouveau site</h2>
		<form>
			<p>
				<label for="pluxml-version">Version de PluXml</label>
				<select id="pluxml-version" name="pluxml-version">
<?php
$versions = array_map(
	function($item) {
		return preg_replace('@^PluXml-@', '', $item);
	},
	glob('PluXml-*', GLOB_ONLYDIR)
);
natsort($versions);
foreach(array_reverse($versions) as $version) {
	echo <<< VERSION
					<option>$version</option>

VERSION;
}

$value = 'data-'.strftime('%F');
$folders = glob()
?>
				</select>
			</p>
			<p class="flex">
				<label for="new-site">Nom</label>
				<input id="new-site" type="text" name="new-site" value="<?php echo $value; ?>" maxlength="25" required />
				<input type="submit" />
			</p>
		</form>
	</div>
	<div>
		<h2>Plugins</h2>
		<p><em>Les plugins sont communs à toutes les versions de PluXml.</em></p>
<?php
$plugins = array_map(
	function($item) {
		return str_replace('plugins/', '', $item);
	},
	glob('plugins/*', GLOB_ONLYDIR)
);
if(!empty($plugins)) {
?>
		<ul>
<?php
foreach($plugins as $plugin) {
	echo <<< EOT
			<li>$plugin</li>

EOT;
}
?>
		</ul>
<?php
}
?>
	</div>
</div>
</body>
</html>