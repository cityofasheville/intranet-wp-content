<?php
/*
Plugin Name: WP Project Manager - Frontend
Plugin URI: http://wedevs.com
Description: Frontend functionality for WP Project Manager
Version: 1.2.1
Author: Tareq Hasan
Author URI: http://tareq.wedevs.com
License: GPL2
*/

/**
 * Copyright (c) 2013 Tareq Hasan (email: tareq@wedevs.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

/**
 * Project Manager Frontend class
 *
 * @author Tareq Hasan <tareq@wedevs.com>
 */
class CPM_Frontend {

    private $parent_path;
    private $plugin_slug = 'cpm-frontend';

    function __construct() {

        $this->parent_path = dirname( dirname( __FILE__ ) ) . '/wedevs-project-manager';

        register_activation_hook( __FILE__, array($this, 'install_plugin') );
        
        add_action( 'wp_enqueue_scripts', array('WeDevs_CPM', 'admin_scripts') );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );

        add_action( 'admin_notices', array($this, 'update_notification') );
        
        add_shortcode( 'cpm', array($this, 'shortcode') );
        
        add_filter( 'cpm_settings_sections', array( $this, 'settings_section') );
        add_filter( 'cpm_settings_fields', array( $this, 'page_settings') );
       
        $this->includes();
        $this->instantiate();
        $this->form_actions();

    }

    function settings_section( $section ) {
        $section[] = array(
            'id' => 'cpm_page',
            'title' => __( 'Page Settings', 'cpmf' )
        );

        return $section;
    }

    function page_settings( $settings_fields ) {
        $pages_array = CPM_Admin::get_post_type( 'page' );
        
        $settings_fields['cpm_page'] = array(
            array(
                'name' => 'project',
                'label' => __('Project', 'cpmf'),
                'type' => 'select',
                'options' => $pages_array,
            ),

            array(
                'name' => 'my_task',
                'label' => __( 'My Task', 'cpmf' ),
                'type' => 'select',
                'options' => $pages_array,
            ),
            array(
                'name' => 'calendar',
                'label' => __( 'Calendar', 'cpmf' ),
                'type' => 'select',
                'options' => $pages_array,
            ),

        );

        return $settings_fields;
    }

    /**
     * Load styles and scripts
     *
     * @since 1.0
     */
    function enqueue_scripts() {
        wp_enqueue_style( 'cpm-frontend', plugins_url( 'css/style.css', __FILE__ ) );
    }

    /**
     * Check if the WP Project Manager plugin installed
     *
     * @since 1.0
     * @return boolean
     */
    function is_plugin_installed() {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        if ( is_plugin_active( 'wedevs-project-manager/cpm.php' ) ) {
            return true;
        }

        if ( is_plugin_active( 'wedevs-project-manager-pro/cpm.php' ) ) {
            
            $this->parent_path = dirname( dirname( __FILE__ ) ) . '/wedevs-project-manager-pro';

            return true;
        }

        return false;
    }

    /**
     * Checks if the parent plugin is already installed, otherwise deactivate
     * itself.
     *
     * @since 1.0
     */
    function install_plugin() {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        if ( !$this->is_plugin_installed() ) {
            deactivate_plugins( __FILE__ );
            exit('"WP Project Manger" plugin is not installed. Install the plugin first.');
        }
    }

    /**
     * Includes all required files if the parent plugin is intalled
     *
     * @since 1.0
     */
    function includes() {
        if ( !$this->is_plugin_installed() ) {
            return;
        }

        if ( !is_admin() ) {
            require_once $this->parent_path  . '/includes/functions.php';
            require_once $this->parent_path  . '/includes/urls.php';
            require_once $this->parent_path  . '/includes/html.php';
            require_once $this->parent_path  . '/includes/shortcodes.php';
        }

        // load url filters
        require_once dirname( __FILE__)  . '/urls.php';
    }

    /**
     * Instantiate required classes
     *
     * @since 1.0
     */
    function instantiate() {

        if ( !$this->is_plugin_installed() ) {
            return;
        }

        //instantiate the URL filter class only if it's the frontend area or
        //the request is made from frontend
        if ( ! is_admin() || isset( $_REQUEST['cpmf_url'] ) ||  ( isset( $_REQUEST['is_admin'] ) &&  $_REQUEST['is_admin']== 'no' ) ) {

            new CPM_Frontend_URLs();
        }
    }

    /**
     * Main shortcode handler function
     *
     * @since 1.0
     * @param array $atts
     * @param string $content
     * @return string
     */
    function shortcode( $atts, $content = null ) {
        extract( shortcode_atts( array('id' => 0), $atts ) );

        if ( !$this->is_plugin_installed() ) {
            return __( 'Sorry, main plugin is not installed', 'cpmf');
        }
        
        if ( !is_user_logged_in() ) {
            return wp_login_form( array('echo' => false) );
        }

        if ( !is_user_logged_in() ) {
            return wp_login_form( array('echo' => false) );
        }

        if ( $id ) {
            $project_id = $id;
        } else {
            $project_id = isset( $_GET['project_id'] ) ? intval( $_GET['project_id'] ) : 0;
        }

        ob_start();
        ?>

        <div class="cpm">
            <?php
            if ( $project_id ) {
                $this->single_project( $project_id );
            } else {
                $this->list_projects();
            }
            ?>
        </div> <!-- .cpm -->
        <?php

        return ob_get_clean();
    }

    /**
     * List all projects
     *
     * @since 1.0
     */
    function list_projects() {
        $project_obj = CPM_Project::getInstance();
        $projects = $project_obj->get_projects();
        $status_class = isset( $_GET['status'] ) ? $_GET['status'] : 'active';
        
        if ( function_exists( 'cpm_project_count' ) ) {
            $count = cpm_project_count();
        }
        ?>

        <div class="icon32" id="icon-themes"><br></div>
        <h2><?php _e( 'Project Manager', 'cpm' ); ?></h2>

        <?php
        if ( function_exists( 'cpm_project_filters' ) ) {
            cpm_project_filters();
        }
        ?>
        
        <div class="cpm-projects">
            
            <?php if ( function_exists( 'cpm_project_filters' ) ) { ?>
                <ul class="list-inline order-statuses-filter">
                    <li<?php echo $status_class == 'all' ? ' class="active"' : ''; ?>>
                        <a href="<?php echo cpm_url_all(); ?>"><?php _e( 'All', 'cpm' ); ?></a>
                    </li>
                    <li<?php echo $status_class == 'active' ? ' class="active"' : ''; ?>>
                        <a class="cpm-active" href="<?php echo cpm_url_active(); ?>"><?php printf( __( 'Active (%d)', 'cpm' ), $count['active'] ); ?></a>
                    </li>
                    <li<?php echo $status_class == 'archive' ? ' class="active"' : ''; ?>>
                        <a class="cpm-archive-head" href="<?php echo cpm_url_archive(); ?>"><?php printf( __( 'Completed (%d)', 'cpm' ), $count['archive'] ); ?></a>   
                    </li>
                </ul>
            <?php } ?>

            <?php if ( cpm_manage_capability( 'project_create_role' ) ) { ?>
                <nav class="cpm-new-project">
                    <a href="#" id="cpm-create-project"><span><?php _e( 'New Project', 'cpm' ); ?></span></a>
                </nav>
            <?php } ?>

            <?php
            foreach ($projects as $project) {

                if ( !$project_obj->has_permission( $project ) ) {
                    continue;
                }
                ?>
                <article class="cpm-project">
                    <?php if ( cpm_is_project_archived( $project->ID ) ) { ?>
                        <div class="cpm-completed-wrap"><div class="ribbon-green"><?php _e( 'Completed', 'cpm' ); ?></div></div>
                    <?php } ?>

                    <a href="<?php echo cpm_url_project_details( $project->ID ); ?>">
                        <h5><?php echo get_the_title( $project->ID ); ?></h5>
                        
                        <div class="cpm-project-detail"><?php echo cpm_excerpt( $project->post_content, 55 ); ?></div>
                        <div class="cpm-project-meta">
                            <?php echo cpm_project_summary( $project->info ); ?>
                        </div>

                        <footer class="cpm-project-people">
                            <?php

                            if(count( $project->users )) {
                                foreach( $project->users as $id=>$user_meta) {
                                    echo get_avatar( $id, 48,'', $user_meta['name']);
                                }
                            }
                                

                            ?>

                        </footer>
                    </a>

                    <?php
                        $progress = $project_obj->get_progress_by_tasks( $project->ID );
                        echo cpm_task_completeness( $progress['total'], $progress['completed'] );
                        
                        if( cpm_user_can_access( $project->ID ) ) {
                            cpm_project_actions( $project->ID ); 
                        }
                     ?> 
                        
                    
                </article>

            <?php } ?>
                
        </div>

        <div id="cpm-project-dialog" title="<?php _e( 'Start a new project', 'cpm' ); ?>" style="display: none;">
            <?php if ( $project_obj->has_admin_rights() ) { ?>
                <?php cpm_project_form(); ?>
            <?php } ?>
        </div>

        <div id="cpm-create-user-wrap">
            <?php if ( $project_obj->has_admin_rights() ) { ?>
                <?php cpm_user_create_form(); ?>
            <?php } ?>
        </div>


        <script type="text/javascript">
            jQuery(function($) {
                $( "#cpm-project-dialog, #cpm-create-user-wrap" ).dialog({
                    autoOpen: false,
                    modal: true,
                    dialogClass: 'cpm-ui-dialog',
                    width: 485,
                    height: 425,
                    position:['middle', 100]
                });
            });

            jQuery(function($) {
                $( "#cpm-create-user-wrap" ).dialog({
                    autoOpen: false,
                    modal: true,
                    dialogClass: 'cpm-ui-dialog',
                    width: 400,
                    height: 353,
                    position:['middle', 100]
                });
            });
        </script>
        <?php
    }

    /**
     * Display a single project
     *
     * @since 1.0
     * @param int $project_id
     */
    function single_project( $project_id ) {
        remove_filter('comments_clauses', 'cpm_hide_comments', 99 );

        $pro_obj = CPM_Project::getInstance();
        $activities = $pro_obj->get_activity( $project_id, array() );

        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'activity';
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'index';

        switch ($tab) {
            
            case 'activity':
                cpm_get_header( __( 'Activity', 'cpm' ), $project_id );

                $this->project_activity( $project_id );
                break;

            case 'settings':
                cpm_get_header( __( 'Activity', 'cpm' ), $project_id );

                $this->project_settings( $project_id );
                break;

            case 'message':

                switch ($action) {
                    case 'single':
                        $message_id = isset( $_GET['message_id'] ) ? intval( $_GET['message_id']) : 0;
                        $this->message_single( $project_id, $message_id );

                        break;

                    default:
                        $this->message_index( $project_id );
                        break;
                }

                break;

            case 'task':

                switch ($action) {
                    case 'single':
                        $list_id = isset( $_GET['list_id'] ) ? intval( $_GET['list_id']) : 0;

                        $this->tasklist_single( $project_id, $list_id );
                        break;

                    case 'todo':
                        $list_id = isset( $_GET['list_id'] ) ? intval( $_GET['list_id']) : 0;
                        $task_id = isset( $_GET['task_id'] ) ? intval( $_GET['task_id']) : 0;

                        $this->task_single( $project_id, $list_id, $task_id );
                        break;

                    default:
                        $this->tasklist_index( $project_id );
                        break;
                }

                break;

            case 'milestone':
                $this->milestone_index( $project_id );
                break;

            case 'files':
                $this->files_index( $project_id );
                break;

            default:
                break;
        }

        do_action( 'cpmf_project_tab', $project_id, $tab, $action );

        // add the filter again
        add_filter('comments_clauses', 'cpm_hide_comments', 99);
    }

    function mytask_front_end() {
       require_once $this->parent_path . '/views/task/my-task.php'; 
    }

    function project_settings($project_id) {

        require_once $this->parent_path . '/views/project/settings.php';
    }

    /**
     * Display activities for a project
     *
     * @since 1.0
     * @param int $project_id
     */
    function project_activity( $project_id ) {
        $pro_obj = CPM_Project::getInstance();
        ?>
        <ul class="cpm-activity dash">
            <?php

            $count = get_comment_count( $project_id );
            $activities = $pro_obj->get_activity( $project_id, array() );

            if ( $activities ) {
                echo cpm_activity_html( $activities );
            }
            ?>
        </ul>

        <?php if ( $count['approved'] > count( $activities ) ) { ?>
            <a href="#" <?php cpm_data_attr( array('project_id' => $project_id, 'start' => count( $activities ) + 1, 'total' => $count['approved']) ); ?> class="button cpm-load-more"><?php _e( 'Load More...', 'cpm' ); ?></a>
        <?php } ?>

        <?php
    }

    function message_index( $project_id ) {
        require_once $this->parent_path . '/views/message/index.php';
    }

    function message_single( $project_id, $message_id ) {
        require_once $this->parent_path . '/views/message/single.php';
    }

    function tasklist_index( $project_id ) {
        require_once $this->parent_path . '/views/task/index.php';
    }

    function tasklist_single( $project_id, $tasklist_id ) {
        require_once $this->parent_path . '/views/task/single.php';
    }

    function task_single( $project_id, $tasklist_id, $task_id ) {
        require_once $this->parent_path . '/views/task/task-single.php';
    }

    function milestone_index( $project_id ) {
        require_once $this->parent_path . '/views/milestone/index.php';
    }

    function files_index( $project_id ) {
        require_once $this->parent_path . '/views/files/index.php';
    }

    /**
     * Attach fom actions in every form in frontend
     *
     * @since 1.0
     * @return void
     */
    function form_actions() {
        if ( is_admin() && ! isset( $_POST['cpmf_url'] )) {
            return;
        }

        // run `form_hidden_input`
        $form_actions = array('cpm_project_form', 'cpm_message_form', 'cpm_tasklist_form',
            'cpm_task_new_form', 'cpm_milestone_form', 'cpm_comment_form, cpm_project_duplicate');

        foreach ($form_actions as $action) {
            add_action( $action, array($this, 'form_hidden_input') );
        }
    }

    /**
     * Adds a hidden input on frontend forms
     *
     * This function adds a hidden permalink input in all forms in the frontend
     * to apply url filters correctly when doing ajax request.
     *
     * @since 1.0
     */
    function form_hidden_input() {

        printf( '<input type="hidden" name="cpmf_url" value="%s" />', get_permalink() );
    }

    /**
     * Check if any updates found of this plugin
     *
     * @global string $wp_version
     * @return bool
     */
    function update_check() {
        global $wp_version, $wpdb;

        require_once ABSPATH . '/wp-admin/includes/plugin.php';

        $plugin_data = get_plugin_data( __FILE__ );

        $plugin_name = $plugin_data['Name'];
        $plugin_version = $plugin_data['Version'];

        $version = get_transient( $this->plugin_slug . '_update_plugin' );
        $duration = 60 * 60 * 12; //every 12 hours

        if ( $version === false ) {

            if ( is_multisite() ) {
                $wp_install = network_site_url();
            } else {
                $wp_install = home_url( '/' );
            }

            $params = array(
                'timeout' => 20,
                'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' ),
                'body' => array(
                    'name' => $plugin_name,
                    'slug' => $this->plugin_slug,
                    'type' => 'plugin',
                    'version' => $plugin_version,
                    'site_url' => $wp_install
                )
            );

            $url = 'http://wedevs.com/?action=wedevs_update_check';
            $response = wp_remote_post( $url, $params );
            $update = wp_remote_retrieve_body( $response );

            if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) {
                return false;
            }

            $json = json_decode( trim( $update ) );
            $version = array(
                'name' => $json->name,
                'latest' => $json->latest,
                'msg' => $json->msg
            );

            set_site_transient( $this->plugin_slug . '_update_plugin', $version, $duration );
        }

        if ( version_compare( $plugin_version, $version['latest'], '<' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Shows the update notification if any update founds
     */
    function update_notification() {
        $version = get_site_transient( $this->plugin_slug . '_update_plugin' );

        if ( $this->update_check() ) {
            $version = get_site_transient( $this->plugin_slug . '_update_plugin' );

            if ( current_user_can( 'update_core' ) ) {
                $msg = sprintf( __( '<strong>%s</strong> version %s is now available! %s.', 'cpmf' ), $version['name'], $version['latest'], $version['msg'] );
            } else {
                $msg = sprintf( __( '%s version %s is now available! Please notify the site administrator.', 'cpmf' ), $version['name'], $version['latest'], $version['msg'] );
            }

            echo "<div class='update-nag'>$msg</div>";
        }
    }

}


new CPM_Frontend();