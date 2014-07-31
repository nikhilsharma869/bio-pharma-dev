<?php
@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

$controls = new NewsletterControls();

if ($controls->is_action('feed_enable')) {
    delete_option('newsletter_feed_demo_disable');
    $controls->messages = 'Feed by Mail demo panels enabled. On next page reload it will show up.';
}

if ($controls->is_action('feed_disable')) {
    update_option('newsletter_feed_demo_disable', 1);
    $controls->messages = 'Feed by Mail demo panel disabled. On next page reload it will disappear.';
}

if ($controls->is_action('check_versions')) {
    $newsletter->hook_check_versions();
    $controls->messages = 'Module versions updated';
}
?>
<div class="wrap main-index">


    <?php $help_url = 'http://www.satollo.net/plugins/newsletter'; ?>
    <?php include NEWSLETTER_DIR . '/header-new.php'; ?>

    <div id="newsletter-title">
        <h2>Welcome and Support</h2>
                <p>
            With my horrible English, everything can be found starting from <a href="http://www.satollo.net/plugins/newsletter" target="_blank">Newsletter Official page</a>
            and every configuration panel has some included documentation just to avoid the most common mistakes.
        </p>
    </div>
    <div class="newsletter-separator"></div>


    <?php $controls->show(); ?>
    <form method="post" action="">
        <?php $controls->init(); ?>

        <h3>Few minutes to get the most out of Newsletter</h3>

        <ol>
            <li>
                <em>It (should) work!</em> Newsletter <strong>works out of the box</strong>, you should only
                <a href="widgets.php"><strong>add the Newsletter Widget</strong></a> to the sidebar and subscriptions will start to get in.
            </li>

            <li>
                <em>Subscription page.</em> If you feel more confortable with a <strong>subscription page</strong>, let Newsletter create one for you: on
                the <a href="admin.php?page=newsletter_subscription_options">subscription configuration panel</a>. You can keep both the
                widget and the page, of course.
            </li>

            <li>
                <em>Translations.</em> The <strong>administrative panels</strong> are only in (my bad) English but any other public
                message and label and button can be translated on <a href="admin.php?page=newsletter_subscription_options">subscription configuration panel</a>:
                please <strong>explore it</strong>.
            </li>

            <li>
                <em>More about subscription.</em> The subscription and unsubscription processes to a mailing
                list <strong>must be clear</strong> to the blog owner. <a href="http://www.satollo.net/plugins/newsletter/subscription-module" target="_blank">You can find more on Satollo.net</a>.
            </li>
        </ol>

        <h3>Something is not working (it could happen)</h3>

        <ol>
            <li>
                <em>No emails are sent.</em> This is mostly a problem of your provider. <strong>Make a test</strong> using the instructions you find on
                the diagnostic panel.
            </li>
            <li>
                <em>I get a 500/fatal error during subscription.</em> This is mostly a problem of file permissions. On the diagnostic
                panel there is a check and on
                <a target="_blank" href="http://www.satollo.net/plugins/newsletter/subscription-module#errors">Satollo.net there are some solutions</a>.
            </li>
        </ol>

        <h3>I want to create and send a newsletter</h3>

        <ol>
            <li>
                <em>I want to create a newsletter.</em> Use the <a href="admin.php?page=newsletter_emails_index">newsletters panel</a>
                <strong>choose a theme</strong>, preview, twick it if needed and create your message.
            </li>
            <li>
                <em>I want to test my newsletter.</em> Save the newsletter and move to the
                <a href="admin.php?page=newsletter_users_index">subscribers panel</a>.
                Create some subscribers manually using your own email addresses and mark them as test subscribers. They will be
                used for newsletter tests.
            </li>
            <li>
                <em>I want to send my newsletter.</em> Simple, press the send button. The email is created and put on
                <a href="http://www.satollo.net/plugins/newsletter/newsletter-delivery-engine" target="_blank">delivery engine queue</a>.
                On newsletter list, it will be shown as "sending".
            </li>
            <li>
                <em>The newsletter is going out too slowly.</em> The <a href="http://www.satollo.net/plugins/newsletter/newsletter-delivery-engine" target="_blank">delivery engine</a> sends
                emails as quickly as configured, see the <a href="admin.php?page=newsletter_main_main">main
                    configuration panel</a>. Look at your provider documentation as well, since it surely has a hourly limit.
            </li>
        </ol>

        <h3>Modules</h3>
        <p>
            Below is the list of available modules that can be used with Newsletter plugin. Some modules are the "core" part
            of Newsletter and are automatically updated with Newsletter official updates. Other modules are <strong>extensions</strong> and
            can be downloaded from <a href="http://www.satollo.net/downloads" target="_blank">www.satollo.net/downloads</a>.
            <br>
            Extensions must be installed in the folder wp-content/extensions/newsletter.
        </p>

        <table class="widefat" style="width: auto">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Version</th>
                    <th>Available version</th>
                </tr>
            </thead>
            <!-- TODO: Should be a cicle of installed modules -->
            <tbody>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/reports-module" target="_blank">Reports</a>
                        <br><small>Extends the statistics system with a better report</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('reports') && class_exists('NewsletterReports')) { ?>
                        <td><?php echo NewsletterReports::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_reports_available_version'); ?></td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/feed-by-mail-module" target="_blank">Feed by Mail (Demo)</a>
                        <br><small>Demostrative panels of the Feed by Mail module</small>
                    </td>
                    <?php if (get_option('newsletter_feed_demo_disable') != 1) { ?>
                        <td><?php $controls->button('feed_disable', 'Disable'); ?></td>
                    <?php } else { ?>
                        <td><?php $controls->button('feed_enable', 'Enable'); ?></td>
                    <?php } ?>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/feed-by-mail-module" target="_blank">Feed by Mail</a>
                        <br><small>Automatically generate and send email with blog contents</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('feed') && class_exists('NewsletterFeed')) { ?>
                        <td><?php echo NewsletterFeed::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_feed_available_version'); ?></td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/follow-up-module" target="_blank">Follow Up</a>
                        <br><small>Sends email series after a subscriber signs up</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('followup') && class_exists('NewsletterFollowup')) { ?>
                        <td><?php echo NewsletterFollowup::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_followup_available_version'); ?></td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/facebook-up-module" target="_blank">Facebook</a>
                        <br><small>Newsletter sign up (easy) with Facebook</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('facebook') && method_exists('NewsletterFacebook', 'instance')) { ?>
                        <td><?php echo NewsletterFacebook::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_facebook_available_version'); ?></td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/sendgrid-module" target="_blank">SendGrid</a>
                        <br><small>Integrates with <a href="http://www.satollo.net/affiliate/sendgrid" target="_blank">SendGrid</a> SMTP and bounce report</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('sendgrid') && class_exists('NewsletterSendgrid')) { ?>
                        <td><?php echo NewsletterSendgrid::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_sendgrid_available_version'); ?></td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/mandrill-module" target="_blank">Mandrill</a>
                        <br><small>Integrates with <a href="http://www.mandrill.com/" target="_blank">Mandrill by Mailchimp</a> SMTP and bounce report (experimental)</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('mandrill') && class_exists('NewsletterMandrill')) { ?>
                        <td><?php echo NewsletterMandrill::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_mandrill_available_version'); ?></td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/popup-module" target="_blank">Popup</a>
                        <br><small>A very simple subscription popup (experimental)</small>
                    </td>
                    <?php if (NewsletterModule::extension_exists('popup') && class_exists('NewsletterPopup')) { ?>
                        <td><?php echo NewsletterPopup::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_popup_available_version'); ?></td>
                </tr>                
                <tr>
                    <td>
                        <a href="http://www.satollo.net/plugins/newsletter/mailjet-module" target="_blank">MailJet</a>
                        <br><small>Integrates with MailJet SMTP service.
                    </td>
                    <?php if (NewsletterModule::extension_exists('mailjet') && class_exists('NewsletterMailjet')) { ?>
                        <td><?php echo NewsletterMailjet::instance()->version; ?></td>
                    <?php } else { ?>
                        <td>Not installed</td>
                    <?php } ?>
                    <td><?php echo get_option('newsletter_mailjet_available_version'); ?></td>
                </tr>
            </tbody>
        </table>

        <?php $controls->button('check_versions', 'Check for new versions'); ?>

        <h3>Support</h3>
        <p>
            There are few options to find or ask for support:
        </p>
        <ul>
            <li><a href="http://www.satollo.net/plugins/newsletter" target="_blank">The official Newsletter page</a> contains information and links to documentation and FAQ</li>
            <li><a href="http://www.satollo.net/forums/forum/newsletter-plugin" target="_blank">The official Newsletter forum</a> where to find solutions or create new requests</li>
            <li><a href="http://www.satollo.net/tag/newsletter" target="_blank">Newsletter articles and comments</a> are a source of solutions</li>
            <li>Only for <a href="http://www.satollo.net/membership" target="_blank">members</a> the <a href="http://www.satollo.net/support-form" target="_blank">support page</a>
            <li>Write directly to me at stefano@satollo.net</li>
        </ul>

        <h3>Collaboration</h3>
        <p>
            Any kind of collaboration for this free plugin is welcome (of course). I set up a
            <a href="http://www.satollo.net/plugins/newsletter/newsletter-collaboration" target="_blank">How to collaborate</a>
            page.
        </p>

        <h3>Documentation</h3>
        <p>
            Below are the pages on www.satollo.net which document Newsletter. Since the site evolves, more pages can be available and
            the full list is always up-to-date on main Newsletter page.
        </p>

        <ul>
            <li><a href="http://www.satollo.net/plugins/newsletter" target="_blank">Official Newsletter page</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-configuration" target="_blank">Main configuration</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-diagnostic" target="_blank">Diagnostic</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-faq" target="_blank">FAQ</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-delivery-engine" target="_blank">Delivery Engine</a></li>


            <li><a href="http://www.satollo.net/plugins/newsletter/subscription-module" target="_blank">Subscription Module</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-forms" target="_blank">Subscription Forms</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-preferences" target="_blank">Subscriber's preferences</a></li>

            <li><a href="http://www.satollo.net/plugins/newsletter/newsletters-module" target="_blank">Newsletters Module</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/newsletter-themes" target="_blank">Themes</a></li>

            <li><a href="http://www.satollo.net/plugins/newsletter/subscribers-module" target="_blank">Subscribers Module</a></li>
            <li><a href="http://www.satollo.net/plugins/newsletter/statistics-module" target="_blank">Statistics Module</a></li>

            <li><a href="http://www.satollo.net/plugins/newsletter/feed-by-mail-module" target="_blank">Feed by Mail Module</a></li>
            <!--<li><a href="http://www.satollo.net/plugins/newsletter/follow-up-module" target="_blank">Follow Up Module</a></li>
            -->
        </ul>


    </form>

</div>
