<?php
include("connect.php");

// USER MANAGEMENT BEGINS HERE
/**
 * @param int $profile_id
 * @return mixed
 */
function findProfile($profile_id)
{
    $findProfile = selectOne('profile', ['id' => $profile_id]);
    return $findProfile;
}

/**
 * @param int $user_id
 * @return mixed
 */
function findUser($user_id)
{
    $findUser = selectOne('users', ['id' => $user_id]);
    return $findUser;
}

/**
 * @param string $email
 * @return mixed
 */
function findEmail($email)
{
    $findEmail = selectAll('profile', ['email' => $email]);
    if ($findEmail) {
        $output = "Email is in use by another user!";
    } else {
        $output = "Okay!";
    }
    return $output;
}

/**
 * @param string $username
 * @return mixed
 */
function findUsername($username)
{
    $findUsername = selectAll('users', ['username' => $username]);
    if ($findUsername) {
        $output = "Username is in use by another user!";
    } else {
        $output = "Okay!";
    }
    return $output;
}

/**
 * @param string $input
 * @return mixed
 */
function findMemeberLike($input)
{

    $condition2 = [
        'fullname' => $input,
        'first_name' => $input,
        'last_name' => $input,
        'middle_name' => $input,
        'registration_no' => $input
    ];
    $findLike = selectOneLikeOR2('profile', [''], $condition2);
    return $findLike;
}

/**
 * @param string $username
 * @param string $passkey
 * @param string $firstname
 * @param string $lastname
 * @param string $email
 * @param string $usertype
 * @return mixed
 */
function createUser($username, $passkey, $first_name, $last_name, $email, $user_type)
{
    global $connection;

    $checkUsername = findUsername($username);
    if ($checkUsername == "Okay!") {
        $checkEmail = findEmail($email);
        if ($checkEmail == "Okay!") {
            $passkey = password_hash($passkey, PASSWORD_DEFAULT);
            $ProfileData = [
                'first_name' => $first_name,
                'email' => $email,
                'last_name' => $last_name,
                'registration_no' => generateRandomString(10),
                'registration_date' => date('Y-m-d'),
            ];

            $createProfile =  insert('profile', $ProfileData);
            if ($createProfile) {
                $userData = [
                    'username' => $username,
                    'passkey' => $passkey,
                    'profile_id' => $createProfile,
                    'user_type' => $user_type
                ];
                $createUser =  insert('users', $userData);
                if (!$createUser) {
                    $error = mysqli_error($connection); //checking for errors
                    $output = [
                        'status' => 'Not Successful',
                        'error' => $error
                    ];
                } else {
                    $output = [
                        'status' => 'success',
                        'id' => $createUser
                    ];
                }
            } else {
                $output = [
                    'status' => 'Failed',
                    'error' => "Something Went wrong could not createUser Profile",
                ];
            }
        } else {
            $output = [
                'status' => 'Failed',
                'error' => "Email already exists",
            ];
        }
    } else {
        $output = [
            'status' => 'Failed',
            'error' => "Email already exists",
        ];
    }
    return $output;
}

function findImage($profile_id)
{
    $images = selectAll('images', ['profile_id' => $profile_id]);
    return $images;
}

function storeImageData($client_id, $image_name)
{
    global $connection;
    $imageData = [
        'customers_idcustomers' => $client_id,
        'image_name' => $image_name
    ];
    $uploadImage = insert('images', $imageData);
    if (!$uploadImage) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $uploadImage
        ];
    }
    return $output;
}

function findAdminUsers()
{
    global $connection;
    // create join function?
    // select all from users where id in (select userid from permissions)
    $findUsers = mysqli_query($connection, "SELECT * from users where id in (SELECT users_id from permissions)");
    $users = mysqli_fetch_all($findUsers, MYSQLI_ASSOC);
    return $users;
}

function findUsers()
{
    $findUsers = selectAll('users', ['status' => "ACTIVE"]);
    return $findUsers;
}

function findBannedUsers()
{
    $findUsers = selectAll('users', ['status' => "CLOSED"]);
    return $findUsers;
}

function findPermissions($user_id)
{
    $findPermission = selectOne('permissions', ['users_id' => $user_id]);
    return $findPermission;
}

function findRelationships($profile_id)
{
    $findRelationships = selectAllOr('relationships', ['profile_id' => $profile_id, 'related_to' => $profile_id]);
    return $findRelationships;
}

// ORGANIZATIONS BEGIN HERE
function findOrganizations()
{
    $findOrganizations = selectAll('organization');
    return $findOrganizations;
}

function findOrganization($organization_id)
{
    $findOrganizations = selectOne('organization', ['id' => $organization_id]);
    return $findOrganizations;
}


function createOrganizations($org_name, $description, $type, $meeting_days, $re_occurance)
{
    global $connection;
    $organizationData = [
        'org_name' => $org_name,
        'description' => $description,
        'type' => $type,
        'meeting_days' => $meeting_days,
        're_occurance' => $re_occurance
    ];

    $createOrganization = insert('organization', $organizationData);
    if (!$createOrganization) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $createOrganization
        ];
    }
    return $output;
}


function updateOrganization($id, $org_name, $description, $type, $meeting_days, $re_occurance)
{
    global $connection;
    $organizationData = [
        'org_name' => $org_name,
        'description' => $description,
        'type' => $type,
        'meeting_days' => $meeting_days,
        're_occurance' => $re_occurance
    ];

    $updateOrganization = update('organization', $id, 'id', $organizationData);
    if (!$updateOrganization) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
        ];
    }
    return $output;
}

function findOrganizationsMember($organization_id)
{
    global $connection;
    $findOrganizationsMember = mysqli_query($connection, "SELECT * FROM profile WHERE id IN (SELECT profile_id from organization_has_profile WHERE organization_id = '$organization_id')");
    $organizationMembers = mysqli_fetch_all($findOrganizationsMember, MYSQLI_ASSOC);
    return $organizationMembers;
}

function findOrganizationJoined($profile_id)
{
    $findJoined = selectAll('organization_has_profile', ['profile_id' => $profile_id]);
    return $findJoined;
}

function findOrganizationJoinedMember($profile_id, $organization_id)
{
    $findJoined = selectOne('organization_has_profile', ['profile_id' => $profile_id, 'organization_id' => $organization_id]);
    return $findJoined;
}

function addMember($profile_id, $organization_id, $date_joined, $position)
{
    global $connection;

    $memberData = [
        'profile_id' => $profile_id,
        'organization_id' => $organization_id,
        'date_joined' => $date_joined,
        'position' => $position
    ];
    $addMember = insert('organization_has_profile', $memberData);
    if (!$addMember) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
        ];
    }
    return $output;
}


// MASS BOOKINGS BEGIN HERE
function findMassBookings()
{
    $findBookings = selectAll('mass_booking');
    return $findBookings;
}

function bookMass($mass_intention, $persons, $booked_by)
{
    global $connection;
    $massBookingData = [
        'mass_intention' => $mass_intention,
        'person' => $persons,
        'profile_id' => $booked_by
    ];

    $createBooking = insert('mass_booking', $massBookingData);
    if (!$createBooking) {
        $message = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $message
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $createBooking
        ];
    }
    return $output;
}

function massBookingUpdate($id)
{
    global $connection;
    $changeStatus = update('mass_booking', $id, 'id', ['status' => 1]);
    if (!$changeStatus) {
        $message = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $message
        ];
    } else {
        $output = [
            'status' => 'success'
        ];
    }
    return $output;
}

// FEEDS BEGIN HERE
function findFeeds()
{
    $findFeeds = selectAllWithOrder('feeds', '', 'id', 'DESC');
    return $findFeeds;
}

function createFeed($title, $message, $feed_type, $date_posted, $posted_by)
{
    global $connection;
    $feedsData = [
        'title' => $title,
        'message' => $message,
        'feed_type' => $feed_type,
        'date_posted' => $date_posted,
        'posted_by' => $posted_by
    ];

    $createFeed = insert('feeds', $feedsData);
    if (!$createFeed) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $createFeed
        ];
    }
    return $output;
}

// SACRAMENTS BEGIN HERE
/**
 * @return mixed
 */
function findSacraments()
{
    $findSacraments = selectAll('sacraments');
    return $findSacraments;
}

/**
 * @param $sacrament_id
 * @return mixed
 */
function findSacrament($sacrament_id)
{
    $findSacrament = selectOne('sacraments', ['id' => $sacrament_id]);
    return $findSacrament;
}

/**
 * @param int $profile_id
 * @return array|mixed|null
 */
function findSacramentReceived($profile_id)
{
    $findReceived = selectAll('sacraments_recieved', ['profile_id' => $profile_id]);
    return $findReceived;
}

/**
 * @param $profile_id
 * @param $sacrament_id
 * @return mixed
 */
function findSacramentReceivedSpecific($profile_id, $sacrament_id)
{
    $findReceived = selectOne('sacraments_recieved', ['profile_id' => $profile_id, 'sacrament_id' => $sacrament_id]);
    return $findReceived;
}

function findSacramentLimit($profile_id, $sacrament_id)
{
    $findSacrament = findSacrament($sacrament_id);
    $findSacramentRecievied = findSacramentReceivedSpecific($profile_id, $sacrament_id);
    if ($findSacramentRecievied) {
        if ($findSacrament['max_receivable'] > 1)
            $output = [
                'can_receive' => "Yes"
            ];
        else
            $output = [
                'can_receive' => "No"
            ];
    } else
        $output = [
            'can_receive' => "Yes"
        ];

    return $output;
}

function createSacrament($title, $description, $minimum_age, $max_receiveable)
{
    global $connection;
    $sacramentData = [
        'tittle' => $title,
        'description' => $description,
        'minimum_age' => $minimum_age,
        'max_receivable' => $max_receiveable
    ];
    $createSacarment = insert('sacraments', $sacramentData);
    if (!$createSacarment) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $createSacarment
        ];
    }
    return $output;
}

function updateSacrament($id, $title, $description, $minimum_age, $max_receiveable)
{
    global $connection;
    $sacramentData = [
        'title' => $title,
        'description' => $description,
        'minimum_age' => $minimum_age,
        'max_receivable' => $max_receiveable
    ];
    $updateSacraments = update('sacraments', $id, 'id', $sacramentData);
    if (!$updateSacraments) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
        ];
    }
    return $output;
}

function deleteSacrament($id)
{
    global $connection;
    $deleteSacrament = delete('sacraments', $id, 'id');
    if (!$deleteSacrament) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
        ];
    }
    return $output;
}

function recordSacramentReceieved($profile_id, $sacrament_id, $date_receieved, $minister){
    global $connection;

    $memberData = [
        'profile_id' => $profile_id,
        'sacrament_id' => $sacrament_id,
        'date_received' => $date_receieved,
        'ministered_by' => $minister
    ];
    $recordSacramentRecieved = insert('sacraments_recieved', $memberData);
    if (!$recordSacramentRecieved) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
        ];
    }
    return $output;
}

// SUBSCRIPTION MODEL BEGINS HERE
function findSubscriptionModels()
{
    $findModels = selectAll('subscription_model');
    return $findModels;
}

function findSubscriptionModel($subscription_model_id)
{
    $findModel = selectOne('subscription_model', ['id' => $subscription_model_id]);
    return $findModel;
}

function findSubscriptionReoccurence($subscription_model_id)
{
    $findSubscriptionModel = findSubscriptionModel($subscription_model_id);
    switch ($findSubscriptionModel['reoccurence']) {
        case 'Monthly':
            $amountToPay = $findSubscriptionModel['amount'] * 1;
            $output = [
                'amount' => $amountToPay,
                'reoccur' => 1
            ];
            break;

        case 'Bi-Monthly':
            $amountToPay = $findSubscriptionModel['amount'] * 2;
            $output = [
                'amount' => $amountToPay,
                'reoccur' => 2
            ];
            break;

        case 'Quarterly':
            $amountToPay = $findSubscriptionModel['amount'] * 4;
            $output = [
                'amount' => $amountToPay,
                'reoccur' => 4
            ];
            break;

        case 'Bi-Annual':
            $amountToPay = $findSubscriptionModel['amount'] * 6;
            $output = [
                'amount' => $amountToPay,
                'reoccur' => 6
            ];
            break;

        case 'Annual':
            $amountToPay = $findSubscriptionModel['amount'] * 12;
            $output = [
                'amount' => $amountToPay,
                'reoccur' => 12
            ];
            break;

        default:
            $output = [
                'amount' => "invalid",
                'reoccur' => "NIL"
            ];
            break;
    }
    return $output;
}

// PAYMENT BEGINS HERE
function findPayments()
{
    $findPayments = selectAll('payment');
    return $findPayments;
}

function findMembersPayments($profile_id)
{
    $findPayments = selectAll('payment', ['profile_id', $profile_id]);
    return $findPayments;
}

function makeDonation($profile_id, $type, $amount, $description, $transaction_date)
{
    global $connection;

    $donationData = [
        'type' => $type,
        'amount' => $amount,
        'description' => $description,
        'transaction_date' => $transaction_date,
        'profile_id' => $profile_id
    ];
    $storeDonation = insert('donation', $donationData);
    if (!$storeDonation) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $storeDonation
        ];
    }
    return $output;
}

function subscribe($profile_id, $type, $amount, $subscription_model_id, $transaction_date)
{
    global $connection;

    $findReoccurence = findSubscriptionReoccurence($subscription_model_id);
    if ($amount != $findReoccurence['amount']) {
        $output = [
            'message' => "Amount Inputted does not Subscription Amount",
            'satus' => "Not Successful"
        ];
    } else {
        $endDate = addMonth($transaction_date, $findReoccurence['reoccur']);
        $subscribeData = [
            'amount' => $amount,
            'payment_date' => $transaction_date,
            'start_date' => $transaction_date,
            'end_date' => $endDate,
            'subscription_model_id' => $subscription_model_id,
            'profile' => $profile_id
        ];
        $storeSubscription = insert('subscribe', $subscribeData);
        if (!$storeSubscription) {
            $error = mysqli_error($connection); //checking for errors
            $output = [
                'status' => 'Not Successful',
                'message' => $error
            ];
        } else {
            $output = [
                'status' => 'success',
                'id' => $storeSubscription
            ];
        }
    }
    return $output;
}

function makePayment($profile_id, $transaction_type, $id, $amount, $description, $transaction_date, $transaction_id)
{
    global $connection;

    if ($transaction_type == 'Subscription') {
        $paymentData = [
            'profile_id' => $profile_id,
            'amount' => $amount,
            'description' => $description,
            'transaction_date' => $transaction_date,
            'payment_type' => "Subscription",
            'transaction_id' => $transaction_id,
            'subscribe_id' => $id,
            'donation_id' => 0,
        ];
    } else {
        $paymentData = [
            'profile_id' => $profile_id,
            'amount' => $amount,
            'description' => $description,
            'transaction_date' => $transaction_date,
            'payment_type' => $transaction_type,
            'transaction_id' => $transaction_id,
            'donation_id' => $id,
            'subscribe_id' => 0
        ];
    }
    $storePayment = insert('payment', $paymentData);
    if (!$storePayment) {
        $error = mysqli_error($connection); //checking for errors
        $output = [
            'status' => 'Not Successful',
            'message' => $error
        ];
    } else {
        $output = [
            'status' => 'success',
            'id' => $storePayment
        ];
    }

    return $output;
}


// Calendar starts here
function findEvents(){
    $findEvents = selectAll("calendar");
    return $findEvents;
}