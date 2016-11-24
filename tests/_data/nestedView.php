<?php
$this->block('testBlock');
?>
blockValue
<?php
$this->block();

$this->content(__DIR__.'/testView.php');
?>
Nested block <?= $body ?>
<?php
$this->addCSS('http://lib.com/test.css');
$this->addCss('http://lib.com/test.css', true);
$this->addScript('http://lib.com/test.js');
$this->addScript('http://lib.com/test.js', true);

$this->content();
