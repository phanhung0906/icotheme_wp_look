<?php

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    /**
     * I got tired of answering ThemeCheck issues. This will resolve them all.
     *
     * @package     Redux_Framework
     * @subpackage  Redux_ThemeCheck
     * @author      Dovy Paukstys
     */

    // Don't duplicate me!
    if ( ! class_exists( 'Redux_ThemeCheck' ) ) {

        /**
         * Redux Helpers Class
         * Class of useful functions that can/should be shared among all Redux files.
         *
         * @since       1.0.0
         */
        class Redux_ThemeCheck {

            public $dir;

            public function __construct() {

                if ( isset( $_GET['page'] ) && $_GET['page'] == "themecheck" ) {
                    add_action( 'admin_notices', array( $this, 'themeCheckExits' ) );
                }


            }

            public function themeCheckExits() {
                if ( function_exists( 'themecheck_add_page' ) ) {
                    $this->load();
                }
            }

            public function load() {

                $redux = new ReduxFramework();
                $redux->init();



                //if ( ! empty( $redux ) ) {


                    $dir   = ReduxFramework::$_dir . '../';

                    
                    if ( ! ReduxFramework::$_is_plugin ) {
                        $errors = array();

                        if ( file_exists( $dir . '.tx' ) ) {
                            $errors[] = ".tx/";
                        }
                        if ( file_exists( $dir . 'bin' ) ) {
                            $errors[] = "bin/";
                        }
                        if ( file_exists( $dir . 'tests' ) ) {
                            $errors[] = "tests/";
                        }
                        if ( file_exists( $dir . '.gitignore' ) ) {
                            $errors[] = ".gitignore";
                        }

                        if ( file_exists( $dir . '.git' ) ) {
                            $errors[] = ".git/";
                        }
                        if ( file_exists( $dir . 'node_modules' ) ) {
                            $errors[] = "node_modules/";
                        }
                        if ( file_exists( $dir . '.travis.yml' ) ) {
                            $errors[] = ".travis.yml";
                        }
                        if ( file_exists( $dir . 'bootstrap_tests.php' ) ) {
                            $errors[] = "bootstrap_tests.php";
                        }
                        if ( file_exists( $dir . 'phpunit.xml' ) ) {
                            $errors[] = "phpunit.xml";
                        }
                        if ( file_exists( $dir . '.ds_store' ) ) {
                            $errors[] = ".ds_store";
                        }
                        if ( file_exists( $dir . 'codestyles' ) ) {
                            $errors[] = "codestyles/";
                        }

                        if ( ! empty( $errors ) ) {
                            ?>
                            <div class="error">
                            <p><?php
                                    _e( 'The following directories & files are still located in your <strong>Redux</strong>  directory. They may cause errors in Theme-Check.', 'owlshop' );
                                    echo '<br /><ul style="margin-left:15px;">';
                                    foreach ( $errors as $error ) {
                                        echo '<li><strong>~/' . $error . '</strong></li>';
                                    }
                                ?>
                                </ul></p></div><?php
                        }
                    }

            }
        }

        new Redux_ThemeCheck();
    }
