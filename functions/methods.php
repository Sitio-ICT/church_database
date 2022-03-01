<?php
include("connect.php");

// USER MANAGEMENT BEGINS HERE
function findProfile($profile_id)
{
    $findProfile = selectOne('profile', ['id' => $profile_id]);
    return $findProfile;
}

function findUser($user_id){
    $findUser = selectOne('users', ['id' => $user_id]);
    return $findUser;
}

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

function createUser($username, $passkey, $first_name, $last_name, $email)
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
                    'password' => $passkey,
                    'profile_id' => $createProfile
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
    $findOrganizationsMember = mysqli_query($connection, "SELECT * FROM profile WHERE id IN (SELECT profile_id from organization_has_profile WHERE organization_id = $organization_id)");
    $organizationMembers = mysqli_fetch_all($findOrganizationsMember, MYSQLI_ASSOC);
    return $organizationMembers;
}

function findOrganizationJoined($profile_id){
    $findJoined = selectAll('organization_has_profile', ['profile_id' => $profile_id]);
    return $findJoined;
}

function findOrganizationJoinedMember($profile_id, $organization_id){
    $findJoined = selectOne('organization_has_profile', ['profile_id' => $profile_id, 'organization_id' => $organization_id]);
    return $findJoined;
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
function findSacraments(){
    $findSacraments = selectAll('sacraments');
    return $findSacraments;
}

function findSacrament($sacrament_id){
    $findSacrament = selectOne('sacraments', ['id' => $sacrament_id]);
    return $findSacrament;
}

function findSacramentReceived($profile_id){
    $findReceived = selectAll('sacraments_recieved', ['profile_id' => $profile_id]);
    return $findReceived;
}

function createSacrament($title, $description, $minimum_age, $max_receiveable){
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

function updateSacrament($id, $title, $description, $minimum_age, $max_receiveable){
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

function deleteSacrament($id){
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

// PAYMENT BEGINS HERE
function findPayments(){
    $findPayments = selectAll('payment');
    return $findPayments;
}

function findMembersPayments($profile_id){
    $findPayments = selectAll('payment', ['profile_id', $profile_id]);
    return $findPayments;
}