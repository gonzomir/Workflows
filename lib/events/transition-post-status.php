<?php
/**
 * Built in events for post status transitions.
 */

namespace HM\Workflows;

function get_messages_tags() {
	return [
		'title' => function ( $post ) {
			return get_the_title( get_post( $post )->ID );
		},
		'excerpt' => function ( $post ) {
			return get_the_excerpt( $post );
		},
		'content' => function ( $post ) {
			return apply_filters( 'the_content', get_post( $post )->post_content );
		},
		'author' => function ( $post ) {
			$post = get_post( $post );
			setup_postdata( $post );
			$author = get_the_author();
			wp_reset_postdata();
			return $author;
		},
		'url' => function ( $post ) {
			return get_the_permalink( $post );
		}
	];
}

Event::register( 'draft_to_pending' )
	->add_message_tags( get_messages_tags() )
	->add_message_action(
		'preview',
		__( 'Preview post', 'hm-workflows' ),
		function ( $post_id ) {
			return get_preview_post_link( $post_id );
		},
		function ( $post ) {
			return [ 'post_id' => get_post( $post )->ID ];
		},
		[ 'post_id' => 'intval' ]
	)
	->add_message_action(
		'edit',
		__( 'Edit post', 'hm-workflows' ),
		function ( $post_id ) {
			return get_edit_post_link( $post_id );
		},
		function ( $post ) {
			return [ 'post_id' => get_post( $post )->ID ];
		},
		[ 'post_id' => 'intval' ]
	)
	->add_message_action(
		'publish',
		__( 'Publish post', 'hm-workflows' ),
		function ( $post_id ) {
			wp_publish_post( $post_id );
			return get_the_permalink( $post_id );
		},
		function ( $post ) {
			return [ 'post_id' => get_post( $post )->ID ];
		},
		[ 'post_id' => 'intval' ]
	);

Event::register( 'publish_post' )
	->add_message_tags( get_messages_tags() )
	->add_message_action(
		'view',
		__( 'View post', 'hm-workflows' ),
		function ( $post_id ) {
			return get_the_permalink( $post_id );
		},
		function ( $post ) {
			return [ 'post_id' => get_post( $post )->ID ];
		},
		[ 'post_id' => 'intval' ]
	);

Event::register( 'publish_page' )
	->add_message_tags( get_messages_tags() )
	->add_message_action(
		'view',
		__( 'View post', 'hm-workflows' ),
		function ( $post_id ) {
			return get_the_permalink( $post_id );
		},
		function ( $post ) {
			return [ 'post_id' => get_post( $post )->ID ];
		},
		[ 'post_id' => 'intval' ]
	);
