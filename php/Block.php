<?php

namespace Preseto\BlockContext;

class Block {

	const CONTEXT_ENABLE = 'blockContextEnable';
	const CONTEXT_LOGIN_STATE = 'blockContextUserLoginState';

	protected $block;

	public function __construct( $block ) {
		$this->block = $block;
	}

	public function attributes() {
		return array_merge(
			[
				self::CONTEXT_ENABLE => false,
				self::CONTEXT_LOGIN_STATE => null,
			],
			$this->block['attrs']
		);
	}

	public function attribute( $key ) {
		$attributes = $this->attributes();

		if ( isset( $attributes[ $key ] ) ) {
			return $attributes[ $key ];
		}

		return null;
	}

	public function is_context_enabled() {
		return ( ! empty( $this->attribute( self::CONTEXT_ENABLE ) ) );
	}

	public function is_hidden() {
		return ( $this->is_context_enabled() && $this->match_login() );
	}

	public function match_login() {
		$login_state = $this->attribute( self::CONTEXT_LOGIN_STATE );

		if ( ! empty( $login_state ) ) {
			$is_logged_in = is_user_logged_in();

			$rules = [
				'logged-in' => $is_logged_in,
				'logged-out' => ! $is_logged_in,
			];

			return ( ! empty( $rules[ $login_state ] ) );
		}

		return false;
	}

}
