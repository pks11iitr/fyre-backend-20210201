<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();
	$SEX = array("Male" => 0, "Female" => 1);

    $LANG_CATEGORIES_ARRAY = array(
        "Phones, tablets and accessories", //Телефоны, планшеты и аксессуары
        "Cars, motorcycles and other vehicles", //Автомобили, мотоциклы и другой транспорт
        "Real estate", //Недвижимость
        "Clothing, Fashion and Style", //Одежда, мода и стиль
        "Pets", //Домашние животные
        "Computers, game consoles and accessories", //Компьютеры, игровые приставки и аксессуары
        "Cosmetics, perfumes and other health and beauty products", //Косметика, парфюмерия и прочии товары для красоты и здоровья
        "Furniture", //Мебель
        "Shoes", //Обувь
        "Tools and other household goods", //Инструменты и прочие товары для дома
        "Wristwatches", //Наручные часы
        "Business and services"); //Бизнес и услуги

    $TEXT['lang-code'] = "en";
    $TEXT['lang-name'] = "English";

    // For admin panel

    $TEXT['apanel-dashboard'] = "Dashboard";
    $TEXT['apanel-home'] = "Home";
    $TEXT['apanel-support'] = "Support";
    $TEXT['apanel-settings'] = "Settings";
    $TEXT['apanel-logout'] = "Logout";
    $TEXT['apanel-login'] = "Log In";
    $TEXT['apanel-market'] = "Market";
    $TEXT['apanel-reports'] = "Reports";
    $TEXT['apanel-messages'] = "Messages";
    $TEXT['apanel-chats'] = "Chats";
    $TEXT['apanel-chat'] = "Chat";
    $TEXT['apanel-items'] = "Items";
    $TEXT['apanel-users'] = "Users";
    $TEXT['apanel-fcm'] = "Push Notifications";
    $TEXT['apanel-admob'] = "Admob";
    $TEXT['apanel-profile'] = "Profile";

    $TEXT['apanel-categories'] = "Categories";
    $TEXT['apanel-subcategories'] = "Subcategories";
    $TEXT['apanel-category-new'] = "Create Category";
    $TEXT['apanel-category-edit'] = "Edit Category";

    $TEXT['apanel-subcategory-new'] = "Create Subcategory";
    $TEXT['apanel-subcategory-edit'] = "Edit Subcategory";

    $TEXT['apanel-label-category'] = "Category";
    $TEXT['apanel-label-subcategory'] = "Subcategory";
    $TEXT['apanel-label-categories'] = "Categories";
    $TEXT['apanel-label-subcategories'] = "Subcategories";

    $TEXT['apanel-label-general'] = "General";
    $TEXT['apanel-label-stream'] = "Stream";
    $TEXT['apanel-label-settings'] = "Settings";

    $TEXT['apanel-placeholder-username'] = "Username";
    $TEXT['apanel-placeholder-password'] = "Password";
    $TEXT['apanel-placeholder-search'] = "Enter a text";
    $TEXT['apanel-placeholder-category-title'] = "Enter category name";

    $TEXT['apanel-action-login'] = "Log In";
    $TEXT['apanel-action-delete'] = "Delete";
    $TEXT['apanel-action-cancel'] = "Cancel";
    $TEXT['apanel-action-approve'] = "Approve";
    $TEXT['apanel-action-reject'] = "Reject";
    $TEXT['apanel-action-view-more'] = "View more";
    $TEXT['apanel-action-search'] = "Search";
    $TEXT['apanel-action-view'] = "View";
    $TEXT['apanel-action-send'] = "Send";
    $TEXT['apanel-action-edit'] = "Edit";
    $TEXT['apanel-action-rename'] = "Rename";
    $TEXT['apanel-action-save'] = "Save";
    $TEXT['apanel-action-add'] = "Add";
    $TEXT['apanel-action-create'] = "Create";
    $TEXT['apanel-action-close-all-auth'] = "Close all authorizations";
    $TEXT['apanel-action-verified-set'] = "Set account as verified";
    $TEXT['apanel-action-verified-unset'] = "Unset verified";
    $TEXT['apanel-action-create-fcm'] = "Send Personal FCM Message";
    $TEXT['apanel-action-account-block'] = "Block account";
    $TEXT['apanel-action-account-unblock'] = "Unblock account";
    $TEXT['apanel-action-remove-connection'] = "Remove connection";
    $TEXT['apanel-action-admob-on'] = "Turn On AdMob in this account";
    $TEXT['apanel-action-admob-off'] = "Turn Off AdMob in this account";
    $TEXT['apanel-action-delete-photo'] = "Delete Photo";
    $TEXT['apanel-action-delete-cover'] = "Delete Cover";

    $TEXT['apanel-auth-label-title'] = "Authorizations";

    $TEXT['apanel-label-create-at'] = "Create At";
    $TEXT['apanel-label-close-at'] = "Close At";
    $TEXT['apanel-label-signup-at'] = "SignUp Date";
    $TEXT['apanel-label-app-type'] = "App Type";

    $TEXT['apanel-label-account-edit'] = "Edit Profile";
    $TEXT['apanel-label-location'] = "Location";
    $TEXT['apanel-label-balance'] = "Balance";
    $TEXT['apanel-label-fullname'] = "Fullname";
    $TEXT['apanel-label-admob-state'] = "AdMob (on/off AdMob in account)";
    $TEXT['apanel-label-admob-state-active'] = "On (AdMob is active in account)";
    $TEXT['apanel-label-admob-state-inactive'] = "Off (AdMob is not active in account)";
    $TEXT['apanel-label-account-state'] = "Account state";
    $TEXT['apanel-label-account-state-enabled'] = "Account is active";
    $TEXT['apanel-label-account-state-blocked'] = "Account is blocked";
    $TEXT['apanel-label-account-state-disabled'] = "Account is disabled by user";
    $TEXT['apanel-label-account-state-verified'] = "Account verified";
    $TEXT['apanel-label-account-verified'] = "Account is verified.";
    $TEXT['apanel-label-account-unverified'] = "Account is not verified.";
    $TEXT['apanel-label-account-facebook-connected'] = "Connected to Facebook";
    $TEXT['apanel-label-connected'] = "Connected";
    $TEXT['apanel-label-not-connected'] = "Not Connected";

    $TEXT['apanel-label-account-chats'] = "Active chats (not removed)";
    $TEXT['apanel-label-account-items'] = "Items (not removed)";
    $TEXT['apanel-label-account-reports'] = "Reports to profile";

    $TEXT['apanel-label-sort-type'] = "Sort";
    $TEXT['apanel-label-moderation-type'] = "Moderation";
    $TEXT['apanel-label-active-type'] = "Active";
    $TEXT['apanel-label-category'] = "Category";
    $TEXT['apanel-label-search'] = "Search";
    $TEXT['apanel-label-list-empty'] = "List is empty.";
    $TEXT['apanel-label-list-empty-desc'] = "This means that there is no data to display :)";

    $TEXT['apanel-sort-type-new'] = "From new to old";
    $TEXT['apanel-sort-type-old'] = "From old to new";

    $TEXT['apanel-active-type-all'] = "All items";
    $TEXT['apanel-active-type-active'] = "Only active items";

    $TEXT['apanel-moderation-type-all'] = "All items";
    $TEXT['apanel-moderation-type-moderated'] = "Only moderated items";
    $TEXT['apanel-moderation-type-unmoderated'] = "Only not moderated items";

    $TEXT['apanel-report-type-item'] = "Items Reports";
    $TEXT['apanel-report-type-profile'] = "Profile Reports";

    $TEXT['apanel-label-item-active'] = "Active";
    $TEXT['apanel-label-item-inactive'] = "Inactive";
    $TEXT['apanel-label-item-approved'] = "Approved";
    $TEXT['apanel-label-item-rejected'] = "Rejected";

    $TEXT['apanel-label-name'] = "Name";
    $TEXT['apanel-label-count'] = "Count";
    $TEXT['apanel-label-value'] = "Value";

    $TEXT['apanel-label-error'] = "Error!";
    $TEXT['apanel-label-thanks'] = "Thanks!";

    $TEXT['apanel-settings-label-change-password'] = "Change Password";
    $TEXT['apanel-settings-label-change-password-desc'] = "Enter the current and new password";
    $TEXT['apanel-settings-label-current-password'] = "Current Password";
    $TEXT['apanel-settings-label-new-password'] = "New Password";

    $TEXT['apanel-settings-label-password-saved'] = "New password is saved";
    $TEXT['apanel-settings-label-password-error'] = "Invalid current password or incorrectly enter a new password";

    $TEXT['apanel-fcm-label-title'] = "Send Push Notification";
    $TEXT['apanel-fcm-label-recently-title'] = "Recently push-messages";
    $TEXT['apanel-fcm-type-for-all'] = "It will be shown, even if the user is not authorized";
    $TEXT['apanel-fcm-type-for-authorized'] = "Only an authorized user";
    $TEXT['apanel-fcm-type-for-all-users'] = "For all users";
    $TEXT['apanel-fcm-type-for-authorized-users'] = "Only for authorized users";

    $TEXT['apanel-label-tickets'] = "Tickets";
    $TEXT['apanel-label-unknown'] = "Unknown";
    $TEXT['apanel-label-reports'] = "Reports";
    $TEXT['apanel-label-items'] = "Items";
    $TEXT['apanel-label-messages'] = "Messages";
    $TEXT['apanel-label-chats'] = "Chats";

    $TEXT['apanel-label-img'] = "Image";
    $TEXT['apanel-label-abuse'] = "Abuse";
    $TEXT['apanel-label-to-item'] = "To Item";
    $TEXT['apanel-label-to'] = "To";
    $TEXT['apanel-label-from'] = "From";
    $TEXT['apanel-label-subject'] = "Subject";
    $TEXT['apanel-label-text'] = "Text";
    $TEXT['apanel-label-date'] = "Date";
    $TEXT['apanel-label-action'] = "Action";
    $TEXT['apanel-label-warning'] = "Warning!";
    $TEXT['apanel-label-app-changes-effect-desc'] = "In application changes will take effect during the next user authorization.";
    $TEXT['apanel-label-demo-fcm-off-desc'] = "Sending push notifications (FCM) is not available in the demo version mode. That we turned off the sending push notifications (FCM) in the demo version mode to protect users from spam and of foul language.";
    $TEXT['apanel-label-type'] = "Type";
    $TEXT['apanel-label-status'] = "Status";
    $TEXT['apanel-label-delivered'] = "Delivered";
    $TEXT['apanel-label-demo-mode'] = "Demo version!";
    $TEXT['apanel-label-demo-mode-desc'] = "Warning! Enabled demo version mode! The changes you've made will not be saved.";

    $TEXT['apanel-label-total-accounts'] = "Total Accounts";
    $TEXT['apanel-label-total-market-items'] = "Total Classifieds";
    $TEXT['apanel-label-total-chats'] = "Total Chats";
    $TEXT['apanel-label-total-messages'] = "Total Messages";
    $TEXT['apanel-label-removed-chats'] = "Removed Chats";
    $TEXT['apanel-label-removed-messages'] = "Removed Messages";
    $TEXT['apanel-label-active-chats'] = "Active Chats";
    $TEXT['apanel-label-active-messages'] = "Active Messages";

    $TEXT['apanel-label-stats-total-items'] = "Total";
    $TEXT['apanel-label-stats-approved-items'] = "Approved";
    $TEXT['apanel-label-stats-rejected-items'] = "Rejected";
    $TEXT['apanel-label-stats-active-items'] = "Active";
    $TEXT['apanel-label-stats-inactive-items'] = "Inactive";
    $TEXT['apanel-label-stats-removed-items'] = "Removed";
    $TEXT['apanel-label-stats-unmoderated-items'] = "Needs moderation";
    $TEXT['apanel-label-stats-blocked-items'] = "Blocked";

    $TEXT['apanel-label-stats-active-items-reports'] = "Reports to items";
    $TEXT['apanel-label-stats-active-profiles-reports'] = "Reports to profiles";
    $TEXT['apanel-label-stats-active-support-items'] = "Support tickets";
    $TEXT['apanel-label-stats-active-likes'] = "Items in favorites";

    $TEXT['apanel-label-stats-market'] = "Classifieds";
    $TEXT['apanel-label-stats-messages'] = "Messages and Chats";
    $TEXT['apanel-label-stats-accounts'] = "Accounts";
    $TEXT['apanel-label-stats-reports'] = "Reports";
    $TEXT['apanel-label-stats-support'] = "Support";
    $TEXT['apanel-label-stats-other'] = "Other";
    $TEXT['apanel-label-stats-recently-profiles-list'] = "The recently registered users";
    $TEXT['apanel-label-stats-recently-profiles-list-desc'] = "Click on Profile to view details";

    $TEXT['apanel-label-stats-profile-chats'] = "User Active Chats";
    $TEXT['apanel-label-stats-profile-chats-desc'] = "Click on Chat to view messages";

    $TEXT['apanel-label-stats-profile-reports'] = "Active reports to profile";
    $TEXT['apanel-label-stats-profile-items'] = "All Profile items";

    $TEXT['apanel-action-admob-action-off-for-new-users'] = "Turn Off AdMob for new users";
    $TEXT['apanel-action-admob-action-on-for-new-users'] = "Turn On AdMob for new users";
    $TEXT['apanel-action-admob-action-off-for-all-users'] = "Turn Off AdMob in all accounts";
    $TEXT['apanel-action-admob-action-on-for-all-users'] = "Turn On AdMob in all accounts";

    $TEXT['apanel-label-admob-active-accounts'] = "AdMob active in accounts (On)";
    $TEXT['apanel-label-admob-inactive-accounts'] = "Accounts count with deactivated AdMob (Off)";
    $TEXT['apanel-label-admob-default-for-new-accounts'] = "Default AdMob value for new users";

    $TEXT['apanel-delete-dialog-title'] = "Delete";
    $TEXT['apanel-delete-dialog-header'] = "Do you really want to delete it?";
    $TEXT['apanel-delete-category-dialog-sub-header'] = "If you delete a category, all subcategories will be deleted and all items that fall into this category and subcategories will have a default value of 0 (category and subcategory fields in db table)";
    $TEXT['apanel-delete-subcategory-dialog-sub-header'] = "If you delete a subcategory, all items that fall into this subcategory will have a default value of 0 (subcategory field in db table)";

    $TEXT['apanel-label-moderation'] = "Moderation";
    $TEXT['apanel-label-moderation-photos'] = "Profile Photos";
    $TEXT['apanel-label-moderation-covers'] = "Profile Covers";

    // For Web site

    $TEXT['topbar-users'] = "Users";

    $TEXT['topbar-stats'] = "Statistics";

    $TEXT['topbar-signin'] = "Log in";

    $TEXT['topbar-logout'] = "Logout";

    $TEXT['topbar-signup'] = "Sign up";


    $TEXT['topbar-settings'] = "Settings";

    $TEXT['topbar-messages'] = "Messages";

    $TEXT['topbar-support'] = "Support";

    $TEXT['topbar-profile'] = "Profile";

    $TEXT['topbar-likes'] = "Notifications";

    $TEXT['topbar-notifications'] = "Notifications";

    $TEXT['topbar-search'] = "Search";

    $TEXT['topbar-main-page'] = "Home";

    $TEXT['topbar-wall'] = "Home";

    $TEXT['topbar-messages'] = "Messages";


    $TEXT['footer-about'] = "about";

    $TEXT['footer-terms'] = "terms";

    $TEXT['footer-contact'] = "contact us";

    $TEXT['footer-support'] = "support";

    $TEXT['footer-android-application'] = "Android app";

    $TEXT['page-main'] = "Main";

    $TEXT['page-ad'] = "Ads";

    $TEXT['page-users'] = "Users";

    $TEXT['page-terms'] = "Terms and Policies";

    $TEXT['page-about'] = "About";

    $TEXT['page-language'] = "Choose your language";

    $TEXT['page-support'] = "Support";

    $TEXT['page-restore'] = "Password retrieval";

    $TEXT['page-restore-sub-title'] = "Please enter the email that was specified during registration";

    $TEXT['page-signup'] = "create account";

    $TEXT['page-login'] = "Login";

    $TEXT['page-blacklist'] = "Blocked list";

    $TEXT['page-messages'] = "Messages";



    $TEXT['page-search'] = "Search";

    $TEXT['page-profile-report'] = "Report";

    $TEXT['page-profile-block'] = "Block";

    $TEXT['page-profile-upload-avatar'] = "Upload photo";

    $TEXT['page-profile-upload-cover'] = "Upload cover";

    $TEXT['page-profile-report-sub-title'] = "Reported profiles are sent to our moderators for a review. They will ban the reported profiles if they violate terms of use";

    $TEXT['page-profile-block-sub-title'] = "will not be able write comments to your Items and send your messages, and you will not see notifications from";



    $TEXT['page-likes'] = "People who like this";

    $TEXT['page-services'] = "Services";

    $TEXT['page-services-sub-title'] = "Connect Marketplace with your social network accounts";

    $TEXT['page-prompt'] = "create account or login";

    $TEXT['page-settings'] = "Settings";

    $TEXT['page-profile-settings'] = "Profile";

    $TEXT['page-profile-password'] = "Change password";

    $TEXT['page-notifications-likes'] = "Notifications";

    $TEXT['page-profile-deactivation'] = "Deactivate account";

    $TEXT['page-profile-deactivation-sub-title'] = "Leaving us?<br>All your Items will be deleted!<br>If you proceed with deactivating your account, you can always come back. Just enter your login and password on the log-in page. We hope to see you again!";

    $TEXT['page-error-404'] = "Page not found";

    $TEXT['label-location'] = "Location";
    $TEXT['label-facebook-link'] = "Facebook page";
    $TEXT['label-instagram-link'] = "Instagram page";
    $TEXT['label-status'] = "Bio";

    $TEXT['label-error-404'] = "Requested page was not found.";

    $TEXT['label-account-disabled'] = "This user has disabled his account.";

    $TEXT['label-account-blocked'] = "This account has been blocked by the administrator.";

    $TEXT['label-account-deactivated'] = "This account is not activated.";

    $TEXT['label-reposition-cover'] = "Drag to Reposition Cover";

    $TEXT['label-or'] = "or";

    $TEXT['label-and'] = "and";

    $TEXT['label-signup-confirm'] = "By clicking Sign up, you agree to our";



    $TEXT['label-empty-page'] = "Here is empty.";

    $TEXT['label-empty-friends-header'] = "You have no friends.";

    $TEXT['label-empty-likes-header'] = "You have no notifications.";

    $TEXT['label-empty-list'] = "List is empty.";

    $TEXT['label-empty-feeds'] = "Here you'll see updates your friends.";

    $TEXT['label-search-result'] = "Search results";

    $TEXT['label-search-empty'] = "Nothing found.";

    $TEXT['label-search-prompt'] = "Find items by title, text or location.";

    $TEXT['label-who-us'] = "See who with us";

    $TEXT['label-thanks'] = "Hooray!";





    $TEXT['label-messages-privacy'] = "Privacy settings for messages";

    $TEXT['label-messages-allow'] = "Receive messages from anyone.";

    $TEXT['label-messages-allow-desc'] = "You will be able to receive messages from any user";

    $TEXT['label-settings-saved'] = "Settings saved.";

    $TEXT['label-password-saved'] = "Password successfully changed.";

    $TEXT['label-profile-settings-links'] = "And also you can";

    $TEXT['label-photo'] = "Photo";

    $TEXT['label-background'] = "Background";

    $TEXT['label-username'] = "Username";

    $TEXT['label-fullname'] = "Full name";

    $TEXT['label-services'] = "Services";

    $TEXT['label-blacklist'] = "Blocked list";

    $TEXT['label-blacklist-desc'] = "View blocked list";

    $TEXT['label-profile'] = "Profile";

    $TEXT['label-email'] = "Email";

    $TEXT['label-password'] = "Password";

    $TEXT['label-old-password'] = "Current password";

    $TEXT['label-new-password'] = "New password";

    $TEXT['label-change-password'] = "Change password";

    $TEXT['label-facebook'] = "Facebook";

    $TEXT['label-placeholder-message'] = "Write a message...";

    $TEXT['label-img-format'] = "Maximum size 3 Mb. JPG, PNG";

    $TEXT['label-message'] = "Message";

    $TEXT['label-subject'] = "Subject";

    $TEXT['label-support-message'] = "What are you contacting us about?";

    $TEXT['label-support-sub-title'] = "We are glad to hear from you! ";

    $TEXT['label-profile-reported'] = "Profile reported!";

    $TEXT['label-profile-report-reason-1'] = "This is spam.";

    $TEXT['label-profile-report-reason-2'] = "Hate Speech or violence.";

    $TEXT['label-profile-report-reason-3'] = "Nudity or Pornography.";

    $TEXT['label-profile-report-reason-4'] = "Fake profile.";

    $TEXT['label-profile-report-reason-5'] = "Piracy.";

    $TEXT['label-success'] = "Success";

    $TEXT['label-password-reset-success'] = "A new password has been successfully installed!";

    $TEXT['label-verify'] = "verify";

    $TEXT['label-account-verified'] = "Verified account";

    $TEXT['label-true'] = "true";

    $TEXT['label-false'] = "false";

    $TEXT['label-state'] = "account status";

    $TEXT['label-stats'] = "Statistics";

    $TEXT['label-id'] = "Id";

    $TEXT['label-count'] = "Count";

    $TEXT['label-repeat-password'] = "repeat password";

    $TEXT['label-category'] = "Category";

    $TEXT['label-from-user'] = "from";

    $TEXT['label-to-user'] = "to";

    $TEXT['label-reason'] = "Reason";

    $TEXT['label-action'] = "Action";

    $TEXT['label-warning'] = "Warning!";

    $TEXT['label-connected-with-facebook'] = "Connected with Facebook";

    $TEXT['label-authorization-with-facebook'] = "Authorization via Facebook.";

    $TEXT['label-services-facebook-connected'] = "You have successfully linked My Social Network with your account on Facebook!";

    $TEXT['label-services-facebook-disconnected'] = "Connect with your Facebook account removed.";

    $TEXT['label-services-facebook-error'] = "Your account on Facebook is already associated with another account.";

    $TEXT['action-login-with'] = "Login with";

    $TEXT['action-signup-with'] = "Sign up with";
    $TEXT['action-delete-profile-photo'] = "Delete photo";
    $TEXT['action-delete-profile-cover'] = "Remove the cover image";
    $TEXT['action-change-photo'] = "Change photo";
    $TEXT['action-change-password'] = "Change password";

    $TEXT['action-more'] = "View more";

    $TEXT['action-next'] = "Next";

    $TEXT['action-add-img'] = "Add an image";

    $TEXT['action-remove-img'] = "Delete image";

    $TEXT['action-close'] = "Close";

    $TEXT['action-go-to-conversation'] = "Go to conversation";

    $TEXT['action-post'] = "Post";

    $TEXT['action-remove'] = "Delete";

    $TEXT['action-report'] = "Report";

    $TEXT['action-block'] = "Block";

    $TEXT['action-unblock'] = "UnBlock";

    $TEXT['action-send-message'] = "Message";

    $TEXT['action-change-cover'] = "Change cover";

    $TEXT['action-change'] = "Change";

    $TEXT['action-change-image'] = "Change image";

    $TEXT['action-edit-profile'] = "Edit profile";

    $TEXT['action-edit'] = "Edit";

    $TEXT['action-restore'] = "Restore";

    $TEXT['action-accept'] = "Accept";

    $TEXT['action-reject'] = "Reject";

    $TEXT['label-question-removed'] = "Question has been removed.";

    $TEXT['action-deactivation-profile'] = "Deactivate account";

    $TEXT['action-connect-profile'] = "Connect with social network accounts";

    $TEXT['action-connect-facebook'] = "Connect with Facebook";

    $TEXT['action-disconnect'] = "Remove connection";

    $TEXT['action-back-to-default-signup'] = "Back to the regular registration form";

    $TEXT['action-back-to-main-page'] = "Return to main page";

    $TEXT['action-back-to-previous-page'] = "Return to previous page";

    $TEXT['action-forgot-password'] = "Forgot your password or username?";

    $TEXT['action-full-profile'] = "View full user profile";

    $TEXT['action-delete-image'] = "Delete post image";

    $TEXT['action-send'] = "Send";

    $TEXT['action-cancel'] = "Cancel";

    $TEXT['action-upload'] = "Upload";

    $TEXT['action-search'] = "Search";

    $TEXT['action-change'] = "Change";

    $TEXT['action-save'] = "Save";

    $TEXT['action-login'] = "Log in";

    $TEXT['action-signup'] = "Sign up";

    $TEXT['action-join'] = "JOIN NOW!";
//    $TEXT['action-join'] = "Регистрация";

    $TEXT['action-forgot-password'] = "Forgot password?";

    $TEXT['msg-loading'] = "Loading...";



    $TEXT['msg-login-taken'] = "A user with that username already exists.";

    $TEXT['msg-login-incorrect'] = "Username wrong format.";

    $TEXT['msg-login-incorrect'] = "Username wrong format.";

    $TEXT['msg-fullname-incorrect'] = "Fullname wrong format.";

    $TEXT['msg-password-incorrect'] = "Password wrong format.";

    $TEXT['msg-password-save-error'] = "Password not changed, wrong current password.";

    $TEXT['msg-email-incorrect'] = "Email wrong format.";

    $TEXT['msg-email-taken'] = "User with this email address is already registered.";

    $TEXT['msg-email-not-found'] = "User with this email was not found in the database.";

    $TEXT['msg-reset-password-sent'] = "A message with link to reset your password has been sent to your email.";

    $TEXT['msg-error-unknown'] = "Error. Try again later.";

    $TEXT['msg-error-authorize'] = "Incorrect username or password.";

    $TEXT['msg-error-deactivation'] = "Wrong password.";

    $TEXT['placeholder-users-search'] = "Find users by login. Minimum of 5 characters.";

	$TEXT['ticket-send-success'] = 'In a short time we will review your request and send a response to your email.';

	$TEXT['ticket-send-error'] = 'Please fill all fields.';



    $TEXT['action-show-all'] = "Show all";


    $TEXT['label-image-upload-description'] = "We support JPG, PNG or GIF files.";

    $TEXT['action-select-file-and-upload'] = "Select a file and upload";

    $TEXT['fb-linking'] = "Connect with Facebook";


    $TEXT['label-gender'] = "Gender";
    $TEXT['label-birth-date'] = "Birth Date";
    $TEXT['label-join-date'] = "Join Date";

    $TEXT['gender-unknown'] = "Gender Unknown";
    $TEXT['gender-male'] = "Gender Male";
    $TEXT['gender-female'] = "Gender Female";

    $TEXT['month-jan'] = "January";
    $TEXT['month-feb'] = "February";
    $TEXT['month-mar'] = "March";
    $TEXT['month-apr'] = "April";
    $TEXT['month-may'] = "May";
    $TEXT['month-june'] = "June";
    $TEXT['month-july'] = "July";
    $TEXT['month-aug'] = "August";
    $TEXT['month-sept'] = "September";
    $TEXT['month-oct'] = "October";
    $TEXT['month-nov'] = "November";
    $TEXT['month-dec'] = "December";

    $TEXT['topbar-stream'] = "Recent Items";
    $TEXT['page-categories'] = "Categories";
    $TEXT['topbar-categories'] = "Categories";
    $TEXT['page-favorites'] = "Favorites";
    $TEXT['topbar-favorites'] = "Favorites";

    $TEXT['msg-added-to-favorites'] = "Added to Favorites.";
    $TEXT['msg-removed-from-favorites'] = "Removed from your favorites.";

    $TEXT['page-create-item'] = "Create New Item";
    $TEXT['page-edit-item'] = "Edit Item";
    $TEXT['page-view-item'] = "View Item";

    $TEXT['action-create'] = "Create";

    $TEXT['label-title'] = "Title";
    $TEXT['label-category'] = "Category";
    $TEXT['label-category-choose'] = "Choose category";
    $TEXT['label-subcategory-choose'] = "Choose subcategory";
    $TEXT['label-price'] = "Price";
    $TEXT['label-description'] = "Description";
    $TEXT['label-description-placeholder'] = "Description for Item";
    $TEXT['label-image'] = "Image";
    $TEXT['label-image-placeholder'] = "Image for Item";
    $TEXT['label-allow-comments'] = "Allows comments for this Item";

    $TEXT['label-items'] = "Items";
    $TEXT['label-phone'] = "Mobile Phone number, example: +15417543010";
    $TEXT['msg-phone-incorrect'] = "Phone wrong format.";
    $TEXT['msg-phone-taken'] = "A user with this phone number is already registered.";

    $TEXT['msg-item-removed'] = "Item removed.";
    $TEXT['msg-item-reported'] = "Item reported.";

    $TEXT['notify-comment'] = "added new comment to your item.";
    $TEXT['notify-comment-reply'] = "replied to your comment.";

    $TEXT['label-placeholder-comment'] = "Write a comment...";
    $TEXT['label-placeholder-comments'] = "Comments";

    $TEXT['label-currency'] = "$";


    // new engine

    $TEXT['main-page-browser-title'] = "Classified ads website for buying and selling used goods/things";

    $TEXT['action-continue'] = "Continue";

    $TEXT['label-ad-title'] = "Ad title"; //Заголовок объявления
    $TEXT['label-ad-category'] = "Category"; //Категория
    $TEXT['label-ad-subcategory'] = "Subcategory"; //Категория
    $TEXT['label-ad-currency'] = "Currency"; //Валюта
    $TEXT['label-ad-price'] = "Price"; //Цена
    $TEXT['label-ad-description'] = "Description"; //Описание
    $TEXT['label-ad-photos'] = "Photos"; //Фотографии
    $TEXT['label-ad-phone'] = "Phone number"; //Номер телефона
    $TEXT['label-ad-location'] = "Location";

    $TEXT['label-ad-sub-title'] = "from 5 to 70 characters"; //от 5 до 70 символов
    $TEXT['label-ad-sub-price'] = "should not be 0"; //цена должна быть больше нуля
    $TEXT['label-ad-sub-description'] = "from 10 to 500 characters"; //от 10 до 500 символов
    $TEXT['label-ad-sub-photos'] = "at least one photo. up to 5 photos. formats: jpg, jpeg"; //минимум одна фотография. до 5 фотографий. форматы: JPG, JPEG
    $TEXT['label-ad-sub-phone'] = "example: +14567189456"; //пример: +1456789456
    $TEXT['label-ad-sub-location'] = "Drag the marker or double click on the desired location.";

    $TEXT['placeholder-ad-title'] = "Enter title for you product, object or service"; //Введите наименование товара, объекта или услуги.
    $TEXT['placeholder-ad-description'] = "Add a description for your product/service, specify benefits and important details"; //Добавьте описание вашего товара/услуги, укажите преимущества и важные детали.
    $TEXT['placeholder-ad-phone'] = "Enter your phone number";

    $TEXT['page-edit-ad-title'] = "Edit classified"; //Редактировать объявление
    $TEXT['page-new-ad-title'] = "Create classified"; //Создать объявление
    $TEXT['action-new-ad'] = "Create"; //Создать

    $TEXT['msg-error-ad-title'] = "Enter ad title"; //Введите заголовок объявления
    $TEXT['msg-error-ad-category'] = "Select a category for your product.";
    $TEXT['msg-error-ad-subcategory'] = "Select a subcategory for your product.";
    $TEXT['msg-error-ad-currency'] = "Choose a currency"; //Выберите валюту
    $TEXT['msg-error-ad-price'] = "Enter the price"; //Введите цену
    $TEXT['msg-error-ad-description'] = "Create a description for your product."; //Создайте описание для вашего продукта
    $TEXT['msg-error-ad-photos'] = "You need to add a photo/image"; //Нужно добавить фотографию/картинку
    $TEXT['msg-error-ad-phone'] = "Enter your phone number"; //Введите ваш номер телефона
    $TEXT['msg-error-ad-phone-incorrect'] = "Invalid phone number format"; //Некорректный формат номера
    $TEXT['msg-error-ad-length-title'] = "at least 5 characters"; //не менее 5 символов
    $TEXT['msg-error-ad-length-description'] = "at least 10 characters"; //не менее 10 символов

    // Restore send

    $TEXT['label-restore-sent-title'] = "A password reset email has been sent";
    $TEXT['label-restore-sent-msg'] = "An email has been sent to you with instructions for changing your password.";

    // Restore success

    $TEXT['label-restore-success-title'] = "Password recovery";
    $TEXT['label-restore-success-msg'] = "Congratulations! You have successfully set a new password!";

    // Restore new

    $TEXT['label-restore-new-title'] = "Create new password"; // Создание нового пароля
    $TEXT['label-restore-new-invalid-password-error-msg'] = "Invalid password format"; //Неверный формат пароля
    $TEXT['label-restore-new-match-passwords-error-msg'] = "Passwords do not match"; //Пароли не совпадают

    // Login page

    $TEXT['label-signup-promo'] = "Not registered? Join now!";
    $TEXT['label-remember'] = "Remember me";

    $TEXT['label-login-empty-field'] = "This field must not be empty"; //Это поле не должно быть пустым

    // Signup page

    $TEXT['label-login-promo'] = "Do you have an account? Log in";
    $TEXT['label-terms-start'] = "By clicking Sign up button, you confirm that you have read our";
    $TEXT['label-terms-link'] = "Terms of Use";
    $TEXT['label-terms-and'] = "and";
    $TEXT['label-terms-privacy-link'] = "Privacy policy";
    $TEXT['label-terms-cookies-link'] = "Use of cookies";

    $TEXT['label-signup-sex'] = "Sex";

    $TEXT['label-signup-tooltip-username'] = "This is your login. Used for authorization and as name for your profile page. Only English letters and numbers. At least 5 characters";
    $TEXT['label-signup-tooltip-fullname'] = "Your real name and surname. For example: displayed on your profile page and in messages. At least 2 characters";
    $TEXT['label-signup-tooltip-password'] = "Password for your account. At least 6 characters";
    $TEXT['label-signup-tooltip-email'] = "Your valid email. Used to recover your password and contact you (if necessary). We do not send promotional emails and spam!";
    $TEXT['label-signup-tooltip-sex'] = "Specify your gender. This will make your profile more complete and informative.";

    $TEXT['label-signup-placeholder-username'] = "Your login";
    $TEXT['label-signup-placeholder-fullname'] = "What is your name?";
    $TEXT['label-signup-placeholder-password'] = "Enter your password";
    $TEXT['label-signup-placeholder-email'] = "E-mail address";

    $TEXT['label-signup-error-username'] = "Invalid format. Only English characters and numbers. At least 5 characters"; //Некорректный формат. Только английские символы и цифры. Минимум 5 символов
    $TEXT['label-signup-error-fullname'] = "Invalid format. At least 2 characters"; //Некорректный формат. Минимум 2 символа
    $TEXT['label-signup-error-password'] = "Invalid format. English letters and numbers. At least 6 characters"; //Некорректный формат. Английские буквы и цифры. Минимум 6 символов
    $TEXT['label-signup-error-email'] = "Invalid format"; //Некорректный формат.

    // Footer

    $TEXT['label-footer-about'] = "About";
    $TEXT['label-footer-terms'] = "Terms of Use";
    $TEXT['label-footer-privacy'] = "Privacy policy";
    $TEXT['label-footer-cookies'] = "Use of cookies";
    $TEXT['label-footer-help'] = "Help";
    $TEXT['label-footer-support'] = "Support";

    // Topbar

    $TEXT['label-topbar-home'] = "Home";
    $TEXT['label-topbar-main'] = "Main";
    $TEXT['label-topbar-messages'] = "Messages";
    $TEXT['label-topbar-notifications'] = "Notifications";
    $TEXT['label-topbar-help'] = "Support";
    $TEXT['label-topbar-search'] = "Search";
    $TEXT['label-topbar-favorites'] = "Favorites";

    // Actions

    $TEXT['action-favorites-promo-button'] = "Search now!"; //Ищите сейчас!
    $TEXT['action-new-classified'] = "Add classified";
    $TEXT['action-see-classified'] = "See classified";
    $TEXT['action-find'] = "Search";
    $TEXT['action-see-all'] = "See all";
    $TEXT['action-show'] = "Show";
    $TEXT['action-yes'] = "Yes";
    $TEXT['action-no'] = "No";
    $TEXT['action-sold'] = "Sold";
    $TEXT['action-remove-forever'] = "Delete forever";
    $TEXT['action-item-inactivate'] = "Make inactive";
    $TEXT['action-item-activate'] = "Make active";
    $TEXT['action-show-map'] = "Show on map";

    // Error messages

    $TEXT['msg-photo-file-size-exceeded'] = "File size exceeded";
    $TEXT['msg-photo-file-size-error'] = "File size too large";
    $TEXT['msg-photo-format-error'] = "Invalid image file format";
    $TEXT['msg-photo-width-height-error'] = "Height and width should be more than 300 pixels";
    $TEXT['msg-photo-file-upload-limit'] = "Exceeded file limit for upload";
    $TEXT['msg-empty-fields'] = "All fields are required";
    $TEXT['msg-ad-published'] = "Classified ad successfully published."; //Объявление успешно опубликовано.
    $TEXT['msg-ad-saved'] = "Changes saved successfully"; //Изменения успешно сохранены
    $TEXT['msg-selected-location-error'] = "Location not specified or incorrect location selection";
    $TEXT['msg-contact-promo'] = "Want to contact %s? Join now!"; // Хотите связаться с %s? Присоединяйтесь!
    $TEXT['msg-publish-ad-promo'] = "Post your first classified!";
    $TEXT['msg-empty-profile-items'] = "No classifieds.";
    $TEXT['msg-search-empty'] = "No results found for your query :("; //По вашему запросу ничего не найдено :(
    $TEXT['msg-search-success'] = "Found %d classifieds"; //Найдено %d объявлений
    $TEXT['msg-search-all'] = "Found %d classifieds"; //Найдено %d объявлений
    $TEXT['msg-confirm-delete'] = "Are you sure you want to delete it?"; //Вы уверены, что хотите удалить это?
    $TEXT['msg-feature-disabled'] = "This feature is currently disabled by the administrator. Sorry for temporary inconvenience. Please try again later.";
    $TEXT['msg-block-user-text'] = "User %s will be added to your blacklist. You will not receive personal messages and other notifications from %s. Do you confirm your action?";
    $TEXT['msg-unblock-user-text'] = "User %s will be removed from your blacklist. Do you confirm your action?";
    $TEXT['msg-unblock-user-text-2'] = "User will be removed from your blacklist. Do you confirm your action?";
    $TEXT['msg-item-success-removed'] = "Your classified has been successfully removed"; // Ваше объявление было успешно удалено
    $TEXT['msg-item-success-inactivated'] = "Your classified has been successfully inactivated"; // Ваше объявление было успешно деактивировано
    $TEXT['msg-favorites-added'] = "Added to favorites";
    $TEXT['msg-favorites-removed'] = "Removed from your favorites";

    $TEXT['msg-item-not-active'] = "Classified Ad is not active.";
    $TEXT['msg-item-make-active-promo'] = "To make this ad active - you need to edit it.";
    $TEXT['msg-item-make-active-description'] = "Please make your ad correct. Enter the correct title, category, description and images.";

    $TEXT['msg-confirm-inactive-title'] = "Classified will be marked as \"Inactive\". Classified will not appear in search and in your profile. Your phone number will be hidden in classified."; //Объявление будет отмечено как "Не активно". Объявление не будет отображатся в поиске и в вашем профиле. В объявлении будет скрыт номер Вашего телефона.
    $TEXT['msg-confirm-inactive-hint'] = "You will be able to delete, edit and make this classified active again at any time."; //Вы будете иметь возможность в любое время удалить, отредактировать и сделать это объявление снова активным.
    $TEXT['msg-confirm-inactive-subtitle'] = "Are you sure you want to do it?"; //Вы уверены, что хотите сделать это?

    // Info messages

    $TEXT['page-notifications-empty-list'] = "You have no new notifications";
    $TEXT['page-messages-empty-list'] = "You have no conversations yet";
    $TEXT['page-classifieds-items-empty-list'] = "You have no active classifieds";
    $TEXT['page-empty-list'] = "List is empty";
    $TEXT['page-blacklist-empty-list'] = "You do not have users in your blacklist";
    $TEXT['page-favorites-empty-list'] = "You haven't added anything to your favorites yet";

    // Item View

    $TEXT['page-item-view-title'] = "Classified ad"; //Объявление
    $TEXT['msg-item-not-found'] = "Classified ad does not exist or has been deleted."; //Объявление не существует или было удалено.

    // Pages

    $TEXT['page-about'] = "About";
    $TEXT['page-terms'] = "Terms of Use";
    $TEXT['page-privacy'] = "Privacy policy";
    $TEXT['page-cookies'] = "Use of cookies";
    $TEXT['page-gdpr'] = "GDPR (General Data Protection Regulation) Privacy Rights"; //GDPR (Общий регламент по защите данных)
    $TEXT['page-support'] = "Support";
    $TEXT['page-profile'] = "Profile";
    $TEXT['page-favorites'] = "Favorites";
    $TEXT['page-notifications'] = "Notifications";
    $TEXT['page-messages'] = "Messages";
    $TEXT['page-chat'] = "Chat";
    $TEXT['page-items'] = "Classifieds";

    $TEXT['page-404'] = "Page not found"; //Страница не найдена
    $TEXT['page-404-description'] = "Requested page not found"; //Запрашиваемая страница не найдена

    $TEXT['page-under-construction'] = "Coming Soon"; //Скоро
    $TEXT['page-under-construction-description'] = "Our website is currently undergoing scheduled maintenance. We Should be back shortly. Thank you for your patience."; //Наш веб-сайт в настоящее время проходит плановое техническое обслуживание. Мы должны вернуться в ближайшее время. Спасибо за терпеливость.

    // Support

    $TEXT['label-support-subject'] = "Subject"; //Тема
    $TEXT['label-support-details'] = "Details"; //Подробнее
    $TEXT['label-support-email-placeholder'] = "Your Email"; //Ваш Email
    $TEXT['label-support-subject-placeholder'] = "What do you want to report? Message subject."; //О чем хотите сообщить? Тема сообщения.
    $TEXT['label-support-details-placeholder'] = "Describe problem in detail"; //Опишите проблему детально
    $TEXT['label-support-sent-title'] = "Your request has been received"; //Ваш запрос получен
    $TEXT['label-support-sent-msg'] = "In the near future, we will process your request and contact you if necessary."; //В ближайшее время мы обработает Ваш запрос и свяжемся с Вами, если это будет необходимо.

    // Labels

    $TEXT['placeholder-login-username'] = "Enter your login or email";
    $TEXT['placeholder-login-password'] = "Enter your password";

    $TEXT['label-username-or-email'] = "Username or Email";

    $TEXT['label-search-query'] = "Search text"; //Текст поиска
    $TEXT['placeholder-search-query'] = "What are you looking for?"; //Что вы ищите?
    $TEXT['label-all-categories'] = "All categories"; //Все категории
    $TEXT['label-all-profile-items'] = "%d classifieds"; // %d объявлений
    $TEXT['label-cookie-message'] = "We use tools, such as \"cookies\", to enable essential services and functionality on our site and to collect data on how visitors interact with our site, products and services. By using the website, you agree with our ";

    $TEXT['label-filters'] = "Filters"; //
    $TEXT['label-filters-all'] = "All"; //
    $TEXT['label-filters-comments'] = "Comments"; //
    $TEXT['label-filters-likes'] = "Likes"; //
    $TEXT['label-filters-replies'] = "Replies"; //
    $TEXT['label-filters-approved'] = "Approved"; //
    $TEXT['label-filters-rejected'] = "Rejected"; //

    $TEXT['label-search-filters-moderation-type'] = "Moderation";
    $TEXT['label-search-filters-moderation-only'] = "Only verified by moderators";
    $TEXT['label-search-filters-sort-type'] = "Sort";
    $TEXT['label-search-filters-sort-by-new'] = "From new to old";
    $TEXT['label-search-filters-sort-by-old'] = "From old to new";

    $TEXT['label-search-filters-location-type'] = "Where to looking for?";
    $TEXT['label-search-filters-location-type-all'] = "Everywhere";
    $TEXT['label-search-filters-location-type-selected'] = "Selected location";
    $TEXT['label-search-filters-distance-type'] = "Distance";
    $TEXT['label-search-filters-distance-type-all'] = "Everywhere";
    $TEXT['label-search-filters-distance-type-5'] = "5km";
    $TEXT['label-search-filters-distance-type-15'] = "15km";
    $TEXT['label-search-filters-distance-type-30'] = "30km";
    $TEXT['label-search-filters-distance-type-50'] = "50km";
    $TEXT['label-search-filters-distance-type-100'] = "100km";
    $TEXT['label-search-filters-distance-type-300'] = "300km";
    $TEXT['label-search-filters-distance-type-500'] = "500km";
    $TEXT['label-search-filters-distance-type-700'] = "700km";

    $TEXT['label-optional'] = "optional";
    $TEXT['label-detail'] = "detail";

    $TEXT['label-just-now'] = "just now";

    $TEXT['label-item-approved'] = "Verified";
    $TEXT['label-item-approved-title'] = "Verified by moderator";
    $TEXT['label-item-rejected'] = "Rejected";
    $TEXT['label-item-rejected-title'] = "Rejected by moderator";

    $TEXT['label-item-active'] = "Active";
    $TEXT['label-item-inactive'] = "Inactive";
    $TEXT['label-item-hot'] = "Hot";
    $TEXT['label-item-popular'] = "Popular";
    $TEXT['label-item-new'] = "New";

    $TEXT['label-favorites-add'] = "Add to favorites";
    $TEXT['label-favorites-remove'] = "Remove from favorites";

    $TEXT['label-notify-item'] = "Classified ad";
    $TEXT['label-notify-item-approved'] = "Your %s is approved by a moderator.";
    $TEXT['label-notify-item-rejected'] = "Your %s has been rejected by moderator.";

    $TEXT['label-safety-tips-title'] = "Safety Tips for Buyers";
    $TEXT['label-safety-tips-1'] = "Do not send money before receiving the goods";
    $TEXT['label-safety-tips-2'] = "Check the item before you buy";
    $TEXT['label-safety-tips-3'] = "Payment after receiving and check the goods";
    $TEXT['label-safety-tips-4'] = "Meet the seller at a safe location";

    $TEXT['label-created-by-web-app'] = "Posted from web version";
    $TEXT['label-created-by-android-app'] = "Posted from Android app";
    $TEXT['label-created-by-ios-app'] = "Posted from iOS app";

    $TEXT['label-item-stats'] = "Statistics";
    $TEXT['label-item-stats-views'] = "Views";
    $TEXT['label-item-stats-likes'] = "Likes";
    $TEXT['label-item-stats-favorites'] = "Added to favorites";
    $TEXT['label-item-stats-phone-views'] = "Phone number views";

    $TEXT['label-item-disclaimer-title'] = "Disclaimer";
    $TEXT['label-item-disclaimer-desc'] = "We does not control the content posted by members and therefore assumes no responsibility any liability for any consequence relating directly or indirectly to any action or inaction.";

    $TEXT['label-items-related'] = "Related classifieds";
    $TEXT['label-items-more-from-author'] = "More from %s";
    $TEXT['label-items-latest'] = "Latest classifieds";
    $TEXT['label-items-featured'] = "Feature classifieds";
    $TEXT['label-items-popular'] = "Popular classifieds";

    // Settings

    $TEXT['page-settings'] = "Settings";
    $TEXT['page-settings-account'] = "Settings";
    $TEXT['page-settings-profile'] = "Profile";
    $TEXT['page-settings-privacy'] = "Privacy";
    $TEXT['page-settings-password'] = "Change password";
    $TEXT['page-settings-blacklist'] = "Blacklist";
    $TEXT['page-settings-connections'] = "Social networks";
    $TEXT['page-settings-deactivation'] = "Deactivate account";

    $TEXT['label-privacy-messages'] = "Messages";
    $TEXT['label-privacy-allow-messages'] = "Receive messages";

    $TEXT['label-sex'] = "Sex";
    $TEXT['label-sex-unknown'] = "Not specified";
    $TEXT['label-sex-male'] = "Male";
    $TEXT['label-sex-female'] = "Female";

    $TEXT['label-bio'] = "Bio";
    $TEXT['label-phone-number'] = "Phone number";
    $TEXT['placeholder-phone-number'] = "Phone number, example: +15417543010";


    $TEXT['placeholder-bio'] = "Tell us a little about yourself";
    $TEXT['placeholder-facebook-page'] = "Link to Facebook page";
    $TEXT['placeholder-instagram-page'] = "Link to Instagram page";

    $TEXT['action-deactivate'] = "Deactivate";
    $TEXT['label-password'] = "Password";
    $TEXT['placeholder-password-current'] = "Current password";
    $TEXT['label-password-current'] = "Current password";
    $TEXT['label-password-new'] = "New password";
    $TEXT['placeholder-password-new'] = "New password";

    $TEXT['msg-deactivation-promo'] = "<strong>Warning!</strong><br>All your data, photos, messages and profile will be deleted! You cannot recover this data!";
    $TEXT['msg-deactivation-error'] = "Wrong password.";

    $TEXT['msg-settings-saved'] = "Settings saved.";
    $TEXT['msg-password-saved'] = "Password successfully changed.";

    $TEXT['msg-password-new-format-error'] = "Password not changed, wrong format for new password.";
    $TEXT['msg-password-current-format-error'] = "Password not changed, wrong format for current password.";
    $TEXT['msg-password-current-error'] = "Password not changed, wrong current password.";

    // Dialogs

    $TEXT['dlg-confirm-block-title'] = "Block user"; //Заблокировать пользователя
    $TEXT['dlg-confirm-unblock-title'] = "Unblock user"; //Разблокировать пользователя
    $TEXT['dlg-confirm-action-title'] = "Confirm action";
    $TEXT['dlg-item-title'] = "Item";
    $TEXT['dlg-message-title'] = "Message";
    $TEXT['dlg-message-placeholder'] = "Enter your message...";
    $TEXT['dlg-report-profile-title'] = "Report item";
    $TEXT['dlg-report-item-title'] = "Report";
    $TEXT['dlg-report-sub-title'] = "Reason for your complaint";
    $TEXT['dlg-report-description-label'] = "Description";
    $TEXT['dlg-report-description-placeholder'] = "You can describe in detail the reason for the complaint...";

    // Social connections

    $TEXT['page-settings-connections-sub-title'] = "Connect %s with your social network accounts";

    $TEXT['label-notify-profile-photo-rejected'] = "Your profile photo has been rejected by moderator. Please upload another photo/image.";
    $TEXT['label-notify-profile-cover-rejected'] = "Your profile cover has been rejected by moderator. Please upload another photo/image.";

    //

    $TEXT['label-currency-choose'] = "Choose a currency";
    $TEXT['label-currency-free'] = "Free";
    $TEXT['label-currency-negotiable'] = "Price negotiable";