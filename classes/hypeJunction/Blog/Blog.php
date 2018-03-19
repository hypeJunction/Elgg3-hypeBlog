<?php

namespace hypeJunction\Blog;

use ElggBlog;

class Blog extends ElggBlog {

	/**
	 * {@inheritdoc}
	 */
	public function __set($name, $value) {

		switch ($name) {
			case 'disable_comments' :
				parent::__set('comments_on', $value ? 'Off' : 'On');
				break;

			case 'published_status' :
				parent::__set('status', $value);
				break;
		}

		parent::__set($name, $value);
	}

}
