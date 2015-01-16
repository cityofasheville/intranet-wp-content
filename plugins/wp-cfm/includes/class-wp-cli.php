<?php

/**
 * Manage configuration options.
 */
class WPCFM_CLI_Command extends WP_CLI_Command
{

    /**
     * Push a bundle to the filesystem
     * 
     * ## OPTIONS
     * 
     * <bundle_name>
     * : The bundle name to export (or use "all")
     * 
     * ## EXAMPLES
     * 
     * wp config push bundle_name
     * 
     * @synopsis <bundle_name> [--network]
     * 
     */
    function push( $args, $assoc_args ) {
        if ( isset( $assoc_args['network'] ) ) {
            WPCFM()->options->is_network = true;
        }

        WPCFM()->readwrite->push_bundle( $args[0] );
        WP_CLI::success( 'The bundle has been written to file.' );
    }


    /**
     * Pull a bundle into the database
     * 
     * ## OPTIONS
     * 
     * <bundle_name>
     * : The bundle name to import (or use "all")
     * 
     * ## EXAMPLES
     * 
     * wp config pull bundle_name
     * 
     * @synopsis <bundle_name> [--network]
     * 
     */
    function pull( $args, $assoc_args ) {
        if ( isset( $assoc_args['network'] ) ) {
            WPCFM()->options->is_network = true;
        }

        WPCFM()->readwrite->pull_bundle( $args[0] );
        WP_CLI::success( 'The bundle has been pulled into the database.' );
    }


    /**
     * Compare bundle differences
     * 
     * ## OPTIONS
     * 
     * <bundle_name>
     * : The bundle name to compare (or use "all")
     * 
     * ## EXAMPLES
     * 
     * wp config diff bundle_name
     * 
     * @synopsis <bundle_name>
     * 
     */
    function diff( $args, $assoc_args ) {

    }
}

WP_CLI::add_command( 'config', 'WPCFM_CLI_Command' );
