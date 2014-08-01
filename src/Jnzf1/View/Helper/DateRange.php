<?php
/**
 * Jnzf1
 *
 * PHP version 5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Jnzf1
 * @package   View
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\View\Helper;


/**
 * Jnzf1_View_Helper_DateRange
 *
 * Description Here!
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Zend_View_Helper_Abstract
 */
class DateRange extends \Zend_View_Helper_Abstract
{


    /**
    * Takes one or two TIMESTAMPs, and an optional formatting array of the form
    * ($year, $month, $day),
    * and returns a date that is appropriate to the situation
    * @param int $start
    * @param int $end
    * @param array $fmt
    * @return boolean|string
    */

    /**
    * dateRange
    *
    * @param mixed $start DESCRIPTION
    * @param mixed $end   DESCRIPTION
    * @param mixed $fmt   DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function dateRange( $start, $end = null, $fmt = null )
    {
        if ( ! isset( $start ) ) {
            return false;
        }

        if ( ! isset( $fmt ) ) {
            // default formatting
            $fmt = array( 'Y', 'M', 'j' );
        }

        list( $yr, $mon, $day ) = $fmt;

        if ( ! isset( $end) || $start == $end ) {
            return date("$mon $day, $yr", $start);
        }

        if ( date('M-j-Y', $start) == date('M-j-Y', $end) ) {
            // close enough
            return date("$mon $day, $yr", $start);
        }


        // ok, so $end != $start

        // let's look at the YMD individually, and make a pretty string
        $dates = array(
            's_year' => date($yr, $start),
            'e_year' => date($yr, $end),

            's_month' => date($mon, $start),
            'e_month' => date($mon, $end),

            's_day' => date($day, $start),
            'e_day' => date($day, $end),
        );

        // init dates
        $start_date = '';
        $end_date = '';

        $start_date .= $dates['s_month'];

        if ($dates['s_month'] != $dates['e_month']) {
            $end_date .= $dates['e_month'];
        }

        $start_date .= ' '. $dates['s_day'];

        if ($dates['s_day'] != $dates['e_day']
            || $dates['s_month'] != $dates['e_month']
        ) {
            $end_date .= ' ' . $dates['e_day'];
        }

        if ($dates['s_year'] != $dates['e_year']) {
            $start_date .= ', ' . $dates['s_year'];

            if ($dates['s_month'] == $dates['e_month']) {
                if ( $dates['s_day'] == $dates['e_day'] ) {
                    // same day, same month, different year
                    $end_date = ' ' . $dates['e_day'] . $end_date;
                }
                // same month, but a different year

                $end_date = $dates['e_month'] . $end_date;
            }
        }

        $end_date .= ', ' . $dates['e_year'];

        $complete_date = trim($start_date) . '&ndash;' . trim($end_date);

        return $complete_date;
    }

}

