<?php 
KLoader::loadIdentifier('com://site/twig.aliases');
echo KService::get('com://site/twig.dispatcher')->dispatch();