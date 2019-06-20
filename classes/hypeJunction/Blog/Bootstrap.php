<?php

namespace hypeJunction\Blog;

use Elgg\PluginBootstrap;

class Bootstrap extends PluginBootstrap {

	/**
	 * {@inheritdoc}
	 */
	public function load() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function boot() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		elgg_register_collection('collection:object:blog:all', \hypeJunction\Blog\DefaultBlogCollection::class);
		elgg_register_collection('collection:object:blog:owner', \hypeJunction\Blog\OwnedBlogCollection::class);
		elgg_register_collection('collection:object:blog:friends', \hypeJunction\Blog\FriendsBlogCollection::class);
		elgg_register_collection('collection:object:blog:group', \hypeJunction\Blog\GroupBlogCollection::class);

		elgg_register_plugin_hook_handler('uses:cover', 'object:blog', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('allow_attachments', 'object:blog', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:blog', [\Elgg\Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('uses:autosave', 'object:blog', [\Elgg\Values::class, 'getTrue']);

		elgg_register_plugin_hook_handler('fields', 'object:blog', SetupBlogFields::class);
		
		elgg_unextend_view('object/elements/imprint/contents', 'blog/imprint/status');
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function shutdown() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function activate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function deactivate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function upgrade() {

	}
}