<?php

return [
	'bootstrap' => \hypeJunction\Blog\Bootstrap::class,
	'entities' => [
		'blog' => [
			'type' => 'object',
			'subtype' => 'blog',
			'class' => \hypeJunction\Blog\Blog::class,
			'searchable' => true,
		],
	],
	'routes' => [
		'add:object:blog' => [
			'path' => '/blog/add/{guid}',
			'resource' => 'post/add',
			'defaults' => [
				'type' => 'object',
				'subtype' => 'blog',
			],
		],
		'edit:object:blog' => [
			'path' => '/blog/edit/{guid}',
			'resource' => 'post/edit',
		],
		'view:object:blog' => [
			'path' => '/blog/view/{guid}/{title?}',
			'resource' => 'post/view',
		],
		'collection:object:blog:all' => [
			'path' => '/blog/all',
			'resource' => 'collection/all',
		],
		'collection:object:blog:owner' => [
			'path' => '/blog/owner/{username?}',
			'resource' => 'collection/owner',
		],
		'collection:object:blog:friends' => [
			'path' => '/blog/friends/{username?}',
			'resource' => 'collection/friends',
		],
		'collection:object:blog:group' => [
			'path' => '/blog/group/{guid}',
			'resource' => 'collection/group',
		],
	],
	'upgrades' => [
		\hypeJunction\Blog\MigrateMetadata::class,
	],
];
