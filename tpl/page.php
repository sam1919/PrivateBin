<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="robots" content="noindex" />
		<title><?php echo PrivateBin\i18n::_('PrivateBin'); ?></title>
		<link type="text/css" rel="stylesheet" href="css/privatebin.css?<?php echo rawurlencode($VERSION); ?>" /><?php
if ($SYNTAXHIGHLIGHTING): ?>
		<link type="text/css" rel="stylesheet" href="css/prettify/prettify.css?<?php echo rawurlencode($VERSION); ?>" /><?php
    if (strlen($SYNTAXHIGHLIGHTINGTHEME)): ?>
		<link type="text/css" rel="stylesheet" href="css/prettify/<?php echo rawurlencode($SYNTAXHIGHLIGHTINGTHEME); ?>.css?<?php echo rawurlencode($VERSION); ?>" /><?php
    endif;
endif; ?>
		<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
		<script type="text/javascript" src="js/sjcl-1.0.4.js"></script>
		<script type="text/javascript" src="js/base64-<?php echo rawurlencode($BASE64JSVERSION); ?>.js"></script>
		<script type="text/javascript" src="js/rawdeflate-0.5.js"></script>
		<script type="text/javascript" src="js/rawinflate-0.3.js"></script><?php
if ($SYNTAXHIGHLIGHTING): ?>
		<script type="text/javascript" src="js/prettify.js?<?php echo rawurlencode($VERSION); ?>"></script><?php
endif;
if ($MARKDOWN): ?>
		<script type="text/javascript" src="js/showdown-1.4.1.js"></script><?php
endif; ?>
		<script type="text/javascript" src="js/privatebin.js?<?php echo rawurlencode($VERSION); ?>"></script>
		<!--[if lt IE 10]>
		<style type="text/css">body {padding-left:60px;padding-right:60px;} #ienotice {display:block;} #oldienotice {display:block;}</style>
		<![endif]-->
		<link rel="apple-touch-icon" href="apple-touch-icon.png?<?php echo rawurlencode($VERSION); ?>" sizes="180x180" />
		<link rel="icon" type="image/png" href="favicon-32x32.png?<?php echo rawurlencode($VERSION); ?>" sizes="32x32" />
		<link rel="icon" type="image/png" href="favicon-16x16.png?<?php echo rawurlencode($VERSION); ?>" sizes="16x16" />
		<link rel="manifest" href="manifest.json?<?php echo rawurlencode($VERSION); ?>" />
		<link rel="mask-icon" href="safari-pinned-tab.svg?<?php echo rawurlencode($VERSION); ?>" color="#ffcc00" />
		<link rel="shortcut icon" href="favicon.ico">
		<meta name="msapplication-config" content="browserconfig.xml">
		<meta name="theme-color" content="#ffe57e" />
	</head>
	<body>
		<header>
			<div id="aboutbox">
				<?php echo PrivateBin\i18n::_('PrivateBin is a minimalist, open source online pastebin where the server has zero knowledge of pasted data. Data is encrypted/decrypted <i>in the browser</i> using 256 bits AES. More information on the <a href="https://github.com/PrivateBin/PrivateBin/wiki">project page</a>.'); ?><br /><?php
if (strlen($NOTICE)): ?>
				<span class="blink">▶</span> <?php echo htmlspecialchars($NOTICE);
endif; ?>
			</div>
			<h1 class="title reloadlink"><?php echo PrivateBin\i18n::_('PrivateBin'); ?></h1><br />
			<h2 class="title"><?php echo PrivateBin\i18n::_('Because ignorance is bliss'); ?></h2><br />
			<h3 class="title"><?php echo $VERSION; ?></h3>
			<noscript><div id="noscript" class="nonworking"><?php echo PrivateBin\i18n::_('Javascript is required for PrivateBin to work.<br />Sorry for the inconvenience.'); ?></div></noscript>
			<div id="oldienotice" class="nonworking"><?php echo PrivateBin\i18n::_('PrivateBin requires a modern browser to work.'); ?></div>
			<div id="ienotice"><?php echo PrivateBin\i18n::_('Still using Internet Explorer? Do yourself a favor, switch to a modern browser:'); ?>
				<a href="https://www.mozilla.org/firefox/">Firefox</a>,
				<a href="https://www.opera.com/">Opera</a>,
				<a href="https://www.google.com/chrome">Chrome</a>,
				<a href="https://www.apple.com/safari">Safari</a>...
			</div>
		</header>
		<section>
			<article>
				<div id="status"><?php echo htmlspecialchars($STATUS); ?></div>
				<div id="errormessage" class="hidden"><?php echo htmlspecialchars($ERROR); ?></div>
				<div id="toolbar">
					<button id="newbutton" class="reloadlink hidden"><img src="img/icon_new.png" width="11" height="15" alt="" /><?php echo PrivateBin\i18n::_('New'); ?></button>
					<button id="sendbutton" class="hidden"><img src="img/icon_send.png" width="18" height="15" alt="" /><?php echo PrivateBin\i18n::_('Send'); ?></button><?php
if ($EXPIRECLONE): ?>
					<button id="clonebutton" class="hidden"><img src="img/icon_clone.png" width="15" height="17" alt="" /><?php echo PrivateBin\i18n::_('Clone'); ?></button><?php
endif; ?>
					<button id="rawtextbutton" class="hidden"><img src="img/icon_raw.png" width="15" height="15" alt="" /><?php echo PrivateBin\i18n::_('Raw text'); ?></button>
					<div id="expiration" class="hidden button"><?php echo PrivateBin\i18n::_('Expires'); ?>:
						<select id="pasteExpiration" name="pasteExpiration"><?php
foreach ($EXPIRE as $key => $value): ?>
							<option value="<?php echo $key; ?>"<?php
    if ($key == $EXPIREDEFAULT): ?> selected="selected"<?php
    endif; ?>><?php echo $value; ?></option><?php
endforeach; ?>
						</select>
					</div>
					<div id="remainingtime" class="hidden"></div>
					<div id="burnafterreadingoption" class="button hidden">
						<input type="checkbox" id="burnafterreading" name="burnafterreading" <?php
if ($BURNAFTERREADINGSELECTED): ?> checked="checked"<?php
endif; ?> />
						<label for="burnafterreading"><?php echo PrivateBin\i18n::_('Burn after reading'); ?></label>
					</div><?php
if ($DISCUSSION): ?>
					<div id="opendisc" class="button hidden">
						<input type="checkbox" id="opendiscussion" name="opendiscussion" <?php
    if ($OPENDISCUSSION): ?> checked="checked"<?php
    endif; ?> />
						<label for="opendiscussion" <?php
    if (!$OPENDISCUSSION): ?> style="color: #BBBBBB;"<?php
    endif; ?>><?php echo PrivateBin\i18n::_('Open discussion'); ?></label>
					</div><?php
endif;
if ($PASSWORD): ?>
					<div id="password" class="hidden">
						<input type="password" id="passwordinput" placeholder="<?php echo PrivateBin\i18n::_('Password (recommended)'); ?>" size="32" />
					</div><?php
endif; ?>
					<div id="formatter" class="button hidden"><?php echo PrivateBin\i18n::_('Format'); ?>:
						<select id="pasteFormatter" name="pasteFormatter"><?php
foreach ($FORMATTER as $key => $value): ?>
							<option value="<?php echo $key; ?>"<?php
    if ($key == $FORMATTERDEFAULT): ?> selected="selected"<?php
    endif; ?>><?php echo $value; ?></option><?php
endforeach; ?>
						</select>
					</div><?php
if (strlen($LANGUAGESELECTION)): ?>
					<div id="language" class="button">
						<select name="lang"><?php
    foreach ($LANGUAGES as $key => $value): ?>
							<option class="reloadlink" onclick="document.cookie='lang=<?php echo $key; ?>';" value="<?php echo $key; ?>"<?php
        if ($key == $LANGUAGESELECTION): ?> selected="selected"<?php
        endif; ?>><?php echo $value[0]; ?> (<?php echo $value[1]; ?>)</option><?php
    endforeach; ?>
						</select>
					</div><?php
endif; ?>
				</div>
				<div id="pasteresult" class="hidden">
					<div id="deletelink"></div>
					<div id="pastelink"><?php
if (strlen($URLSHORTENER)): ?>
						<button id="shortenbutton" data-shortener="<?php echo htmlspecialchars($URLSHORTENER); ?>"><img src="img/icon_shorten.png" width="13" height="15" /><?php echo PrivateBin\i18n::_('Shorten URL'); ?></button><?php
endif; ?>
					</div>
				</div><?php
if ($FILEUPLOAD): ?>
				<div id="attachment" class="hidden"><a><?php echo PrivateBin\i18n::_('Download attachment'); ?></a></div>
				<div id="attach" class="hidden">
					<span id="clonedfile" class="hidden"><?php echo PrivateBin\i18n::_('Cloned file attached.'); ?></span>
					<span id="filewrap"><?php echo PrivateBin\i18n::_('Attach a file'); ?>: <input type="file" id="file" name="file" /></span>
					<button id="fileremovebutton"><?php echo PrivateBin\i18n::_('Remove attachment'); ?></button>
				</div><?php
endif; ?>
				<div id="preview" class="hidden">
					<button id="messageedit"><?php echo PrivateBin\i18n::_('Editor'); ?></button>
					<button id="messagepreview"><?php echo PrivateBin\i18n::_('Preview'); ?></button>
				</div>
				<div id="image" class="hidden"></div>
				<div id="prettymessage" class="hidden">
					<pre id="prettyprint" class="prettyprint linenums:1"></pre>
				</div>
				<div id="cleartext" class="hidden"></div>
				<textarea id="message" name="message" cols="80" rows="25" class="hidden"></textarea>
			</article>
		</section>
		<section>
			<div id="discussion" class="hidden">
				<h4 class="title"><?php echo PrivateBin\i18n::_('Discussion'); ?></h4>
				<div id="comments"></div>
			</div>
		</section>
		<div id="cipherdata" class="hidden"><?php echo htmlspecialchars($CIPHERDATA, ENT_NOQUOTES); ?></div>
	</body>
</html>
