<?php

require_once __DIR__ . '/autoloader.php';

return function () {
	elgg_register_event_handler('init', 'system', function () {

		elgg_register_collection('collection:object:blog:all', \hypeJunction\Blog\DefaultBlogCollection::class);
		elgg_register_collection('collection:object:blog:owner', \hypeJunction\Blog\OwnedBlogCollection::class);
		elgg_register_collection('collection:object:blog:friends', \hypeJunction\Blog\FriendsBlogCollection::class);
		elgg_register_collection('collection:object:blog:group', \hypeJunction\Blog\GroupBlogCollection::class);

		elgg_register_plugin_hook_handler('uses:cover', 'object:blog', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('allow_attachments', 'object:blog', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:blog', [\Elgg\Values::class, 'getTrue']);

		elgg_unextend_view('object/elements/imprint/contents', 'blog/imprint/status');
	});
};
