<?php
/**
 * Tracking class.
 *
 * Used for setting up telemetry.
 *
 * @package   Google\Web_Stories
 * @copyright 2020 Google LLC
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/google/web-stories-wp
 */

/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Web_Stories;

/**
 * Tracking class.
 */
class Tracking {
	/**
	 * Web Stories tracking script handle.
	 *
	 * @var string
	 */
	const SCRIPT_HANDLE = 'web-stories-tracking';

	/**
	 * Google Analytics property ID.
	 *
	 * @var string
	 */
	const TRACKING_ID = 'UA-168571240-1';

	/**
	 * Google Analytics 4 measurement ID.
	 *
	 * @var string
	 */
	const TRACKING_ID_GA4 = 'G-T88C9951CM';

	/**
	 * Initializes tracking.
	 *
	 * Registers the setting in WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		// By not passing an actual script src we can print only the inline script.
		wp_register_script(
			self::SCRIPT_HANDLE,
			false,
			[],
			WEBSTORIES_VERSION,
			false
		);

		wp_add_inline_script(
			self::SCRIPT_HANDLE,
			'window.webStoriesTrackingSettings = ' . wp_json_encode( $this->get_settings() ) . ';'
		);
	}

	/**
	 * Returns tracking settings to pass to the inline script.
	 *
	 * @since 1.0.0
	 *
	 * @return array Tracking settings.
	 */
	public function get_settings() {
		return [
			'trackingAllowed' => $this->is_active(),
			'trackingId'      => self::TRACKING_ID,
			'trackingIdGA4'   => self::TRACKING_ID_GA4,
			'appVersion'      => WEBSTORIES_VERSION,
		];
	}

	/**
	 * Is tracking active for the current user?
	 *
	 * @return bool True if tracking enabled, and False if not.
	 */
	public function is_active() {
		return (bool) get_user_meta( get_current_user_id(), User_Preferences::OPTIN_META_KEY, true );
	}
}
