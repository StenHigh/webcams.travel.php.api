<?php
/**
 * Created by PhpStorm.
 * User: sh
 * Date: 20.2.15
 * Time: 7.54
 */

/**
 * Class WebCam
 * Implements the interaction with the API site webcams.travel
 */
class WebcamsTravel
{
    /**
     * @param string $devid Your developer ID. Please <a href="/developers/signup">signup for a developer ID</a> if you do not already have one.
     */
    function __construct( $devid )
    {
        $this->devid = $devid;
        $this->url   = "http://api.webcams.travel/rest?";
    }

    /**
     * Generate URL query parameters
     *
     * @param array $data an associative array of parameters and values to generate the url
     *
     * @return string
     */
    private function buildQuery( $data )
    {
        $data  = (array) $data;
        $query = array(
            'format' => 'php',
            'devid'  => $this->devid,
            'method' => $data['method']
        );
        $query = array_merge( $query, $data );
        return http_build_query( $query );
    }

    /**
     * Method performs formed request
     *
     * @param string $query Formed request to the api
     *
     * @return mixed The result of the query
     */
    private function execQuery( $query )
    {
        $ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_URL            => $query,
            CURLOPT_VERBOSE        => true,
            CURLOPT_RETURNTRANSFER => true
        ) );
        $response = unserialize( curl_exec( $ch ) );
        curl_close( $ch );
        return $response;
    }

    /**
     *Get the profile of an user.
     *
     * @param string $userid The ID of the user.
     *
     * @return mixed
     */
    function getProfile( $userid )
    {
        $query = $this->url . $this->buildQuery( array(
                'method' => 'wct.users.get_profile',
                'userid' => $userid
            ) );
        return $this->execQuery( $query );
    }

    /**
     *Get the favorite webcams of an user.
     *
     * @param int $userid   The ID of the user.
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listFavoriteWebcams( $userid, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.users.list_favorite_webcams',
                'userid'   => $userid,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the details of a webcam.
     *
     * @param int $webcamid The ID of the webcam.
     *
     * @return mixed
     */
    function getDetails( $webcamid )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.get_details',
                'webcamid' => $webcamid
            ) );
        return $this->execQuery( $query );
    }


    /**
     * Get the details of more than one webcam.
     *
     * @param string $webcamids The IDs of the webcams. The IDs must be separated by commas. The maximum allowed number of IDs are 25.
     *
     * @return mixed
     */
    function getDetailsMultiple( $webcamids )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'    => 'wct.webcams.get_details_multiple',
                'webcamids' => $webcamids
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the comments to a webcam.
     *
     * @param int $webcamid The ID of the webcam.
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listComments( $webcamid, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_comments',
                'webcamid' => $webcamid,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams near a given coordinate. To show webcams on a map, we recommend using the new mapBbox method.
     *
     * @param float  $lat      The latitude.
     * @param float  $lng      The longitude.
     * @param float  $radius   The radius that defines "nearby". The maximum allowed radius is 250 kilometers.
     * @param string $unit     The unit of the radius that defines "nearby". Valid values are "deg" (degree), "km" (kilometers), "mi" (miles).
     * @param int    $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page     The page of results to return.
     *
     * @return mixed
     */
    function listNearby( $lat, $lng, $radius = 0.2, $unit = 'deg', $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_nearby',
                'lat'      => $lat,
                'lng'      => $lng,
                'radius'   => $radius,
                'unit'     => $unit,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams with a given tag.
     *
     * @param string $tag      The tag you want to find webcams to.
     * @param int    $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page     The page of results to return.
     *
     * @return mixed
     */
    function listByTag( $tag, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_by_tag',
                'tag'      => $tag,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams of an user.
     *
     * @param int $userid   The ID of the user.
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listByUser( $userid, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_by_user',
                'userid'   => $userid,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams in a given continent.
     *
     * @param string $continent The continent to restrict the listing to. Possible values are AF AN AS EU NA OC SA
     * @param int    $per_page  Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page      The page of results to return.
     *
     * @return mixed
     */
    function listByContinent( $continent, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'    => 'wct.webcams.list_by_continent',
                'continent' => $continent,
                'per_page'  => $per_page,
                'page'      => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams in a given country.
     *
     * @param string $country  The country to restrict the listing to. Possible values are <a href="http://www.iso.org/iso/country_codes/iso_3166_code_lists/english_country_names_and_code_elements.htm">ISO 3166-1-alpha-2 </a> codes.
     * @param int    $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page     The page of results to return.
     *
     * @return mixed
     */
    function listByCountry( $country, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_by_country',
                'country'  => $country,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the newly added webcams.
     *
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listNew( $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_new',
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the recently viewed webcams.
     *
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listRecent( $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_recent',
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the popular webcams.
     *
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listPopular( $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_popular',
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get randomly selected webcams.
     *
     * @param int    $limit Number of webcams to return. The maximum allowed value is 10.
     * @param string $type  Type of the webcams to return. Possible values are (all - Select random webcams from all available webcams, timelapse - Select only random webcams with a time lapse video)
     *
     * @return mixed
     */
    function listRandom( $limit = 1, $type = 'all' )
    {
        $query = $this->url . $this->buildQuery( array(
                'method' => 'wct.webcams.list_random',
                'limit'  => $limit,
                'type'   => $type
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams with time-lapse video.
     *
     * @param int $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int $page     The page of results to return.
     *
     * @return mixed
     */
    function listTimelapse( $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.webcams.list_timelapse',
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Search the webcams by the given query. Only location names are taken into account for the search. The resulting list will contain the webcams that are around the found locations. This is similar to the <a href="http://webcams.travel/search">search on the website</a>.
     *
     * @param string $query    The query to search for.
     * @param int    $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page     The page of results to return.
     *
     * @return mixed
     */
    function searchWebcams( $query, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.search.webcams',
                'query'    => $query,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Search the users of webcams.travel by the given query.
     *
     * @param string $query    The query to search for.
     * @param int    $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page     The page of results to return.
     *
     * @return mixed
     */
    function searchUsers( $query, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.search.users',
                'query'    => $query,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * @param string $query    The query to search for.
     * @param int    $per_page Number of webcams to return per page. The maximum allowed value is 50.
     * @param int    $page     The page of results to return.
     *
     * @return mixed
     */
    function searchTags( $query, $per_page = 10, $page = 1 )
    {
        $query = $this->url . $this->buildQuery( array(
                'method'   => 'wct.search.tags',
                'query'    => $query,
                'per_page' => $per_page,
                'page'     => $page
            ) );
        return $this->execQuery( $query );
    }

    /**
     * Get the webcams in a given bounding box (bbox) at a given zoom level. This method is most useful for displaying the webcams on a map. The webcams are selected based on the given zoom level, such that they are evenly distributed over the given bounding box and they will not overlap when displayed on the map.
     *
     * @param float  $sw_lat The latitude of the south-west (lower-left) corner of the bounding box.
     * @param float  $sw_lng The longitude of the south-west (lower-left) corner of the bounding box.
     * @param float  $ne_lat The latitude of the north-east (upper-right) corner of the bounding box.
     * @param float  $ne_lng The longitude of the north-east (upper-right) corner of the bounding box.
     * @param int    $zoom   The current zoom level of the map.
     * @param string $mapapi The maps API that you are using to display the webcams. Some map APIs use a different scaling for the zoom level. The default is the scaling as it is used by the Google Maps Javascript API. For some map APIs we offer a build-in conversion of the zoom level. These are the APIs that we currently do the conversion for: (google,bing,nokia,yahoo,mapquest) In case the maps API you are using is not listed here, you have to do the zoom level conversion by yourself before you assemble the API call.
     *
     * @return mixed
     */
    function mapBbox( $sw_lat, $sw_lng, $ne_lat, $ne_lng, $zoom, $mapapi = 'google' )
    {
        $query = $this->url . $this->buildQuery( array(
                'method' => 'wct.map.bbox',
                'sw_lat' => $sw_lat,
                'sw_lng' => $sw_lng,
                'ne_lat' => $ne_lat,
                'ne_lng' => $ne_lng,
                'zoom'   => $zoom,
                'mapapi' => $mapapi,
            ) );
        return $this->execQuery( $query );
    }

    /**
     *Lists the countries with the number of webcams in it.
     * The countryid is an <a href="http://www.iso.org/iso/country_codes/iso_3166_code_lists/english_country_names_and_code_elements.htm">ISO 3166-1-alpha-2</a>.
     *
     * @return mixed
     */
    function countriesList()
    {
        $query = $this->url . $this->buildQuery( array(
                'method' => 'wct.countries.list'
            ) );
        return $this->execQuery( $query );
    }
}

// Example used
/*$a      = new WebcamsTravel( '12b46ed7e6931b68772374abfe658a56' );
$result = $a->getDetails( '1010218306' );
var_dump( $result );*/
