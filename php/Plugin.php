<?php

namespace Preseto\BlockContext;

/**
 * WordPress plugin interface.
 */
class Plugin {
	/**
	 * Absolute path to the main plugin file.
	 *
	 * @var string
	 */
	protected string $file;

	/**
	 * Absolute path to the root directory of this plugin.
	 *
	 * @var string
	 */
	protected string $dir;

	/**
	 * Plugin header meta.
	 *
	 * @var array
	 */
	protected array $meta;

	/**
	 * Store the WP uploads dir object.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_upload_dir/
	 * @var array
	 */
	protected array $uploads_dir;

	/**
	 * Setup the plugin.
	 *
	 * @param string $plugin_file_path Absolute path to the main plugin file.
	 */
	public function __construct( string $plugin_file_path ) {
		$this->file = $plugin_file_path;

		$this->dir = dirname( $plugin_file_path );
		$this->uploads_dir = wp_upload_dir( null, false );
	}

	/**
	 * Return the absolute path to the plugin directory.
	 *
	 * @return string
	 */
	public function dir(): string {
		return $this->dir;
	}

	/**
	 * Return the absolute path to the plugin file.
	 *
	 * @return string
	 */
	public function file(): string {
		return $this->file;
	}

	/**
	 * Get the file path relative to the WordPress plugin directory.
	 *
	 * @param  string $file_path Absolute path to any plugin file.
	 *
	 * @return string
	 */
	public function basename( ?string $file_path = null ): string {
		if ( ! isset( $file_path ) ) {
			$file_path = $this->file();
		}

		return plugin_basename( $file_path );
	}

	/**
	 * Get the asset path.
	 *
	 * @param ?string $path_relative Optional path relative to the plugin directory.
	 *
	 * @return string Absolute path to the asset file or the plugin directory.
	 */
	public function asset_path( ?string $path_relative = null ): string {
		if ( isset( $path_relative ) ) {
			return sprintf( '%s/%s', $this->dir, ltrim( $path_relative, '/' ) );
		}

		return $this->dir;
	}

	/**
	 * Get the public URL to the asset file.
	 *
	 * @param string|null $path_relative Relative path to the asset file.
	 */
	public function asset_url( ?string $path_relative = null ): string {
		if ( isset( $path_relative ) ) {
			return plugins_url( ltrim( $path_relative, '/' ), $this->file );
		}

		return plugins_url( '', $this->file );
	}

	public function asset_meta( string $path_relative ): array {
		$meta = [
			'url' => $this->asset_url( $path_relative ),
			'path' => $this->asset_path( $path_relative ),
			'dependencies' => [],
			'version' => null,
		];

		$meta_path = $this->asset_path(
			sprintf(
				'%s/%s.asset.php',
				dirname( $path_relative ),
				pathinfo( $path_relative, PATHINFO_FILENAME )
			)
		);

		if ( is_readable( $meta_path ) ) {
			$build_meta = include $meta_path;

			return array_merge( $meta, $build_meta );
		} elseif ( is_readable( $meta['path'] ) ) {
			$meta['version'] = filemtime( $meta['path'] );
		}

		return $meta;
	}

	/**
	 * Get absolute path to a file in the uploads directory.
	 *
	 * @param  string $path_relative File path relative to the root of the WordPress uploads directory.
	 *
	 * @return string
	 */
	public function uploads_dir( ?string $path_relative = null ): string {
		if ( isset( $path_relative ) ) {
			return sprintf( '%s/%s', $this->uploads_dir['basedir'], $path_relative );
		}

		return $this->uploads_dir['basedir'];
	}

	/**
	 * Get URL to a file in the uploads directory.
	 *
	 * @param  string $path_relative Path to the file relative to the root of the WordPress uploads directory.
	 *
	 * @return string
	 */
	public function uploads_dir_url( ?string $path_relative = null ): string {
		if ( isset( $path_relative ) ) {
			return sprintf( '%s/%s', $this->uploads_dir['baseurl'], $path_relative );
		}

		return $this->uploads_dir['baseurl'];
	}

	/**
	 * Is WP debug mode enabled.
	 *
	 * @return boolean
	 */
	public function is_debug(): bool {
		return ( defined( 'WP_DEBUG' ) && (bool) constant( 'WP_DEBUG' ) );
	}

	/**
	 * Is WP script debug mode enabled.
	 *
	 * @return boolean
	 */
	public function is_script_debug(): bool {
		return ( defined( 'SCRIPT_DEBUG' ) && (bool) constant( 'SCRIPT_DEBUG' ) );
	}

	/**
	 * Return the current version of the plugin.
	 *
	 * @return mixed
	 */
	public function version() {
		return $this->meta( 'Version' );
	}

	/**
	 * Sync the plugin version with the asset version.
	 *
	 * @return string|int
	 */
	public function asset_version() {
		if ( $this->is_debug() || $this->is_script_debug() ) {
			return time();
		}

		return $this->version();
	}

	/**
	 * Get plugin meta data.
	 *
	 * @param string $field Optional field key.
	 *
	 * @return array|string|null
	 */
	public function meta( ?string $field = null ) {
		if ( ! isset( $this->meta ) ) {
			$this->meta = get_plugin_data( $this->file );
		}

		if ( isset( $field ) ) {
			if ( isset( $this->meta[ $field ] ) ) {
				return $this->meta[ $field ];
			}

			return null;
		}

		return $this->meta;
	}
}
