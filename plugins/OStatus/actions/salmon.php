<?php
/*
 * StatusNet - the distributed open-source microblogging tool
 * Copyright (C) 2010, StatusNet, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @package OStatusPlugin
 * @author James Walker <james@status.net>
 */

if (!defined('STATUSNET')) {
    exit(1);
}

class SalmonAction extends Action
{
    var $user     = null;
    var $xml      = null;
    var $activity = null;

    function prepare($args)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->clientError(_('This method requires a POST.'));
        }

        if ($_SERVER['CONTENT_TYPE'] != 'application/atom+xml') {
            $this->clientError(_('Salmon requires application/atom+xml'));
        }

        $id = $this->trimmed('id');

        if (!$id) {
            $this->clientError(_('No ID.'));
        }

        $this->user = User::staticGet($id);

        if (empty($this->user)) {
            $this->clientError(_('No such user.'));
        }

        $xml = file_get_contents('php://input');

        $dom = DOMDocument::loadXML($xml);

        // XXX: check that document element is Atom entry
        // XXX: check the signature

        $this->act = new Activity($dom->documentElement);
    }

    function handle($args)
    {
        common_log(LOG_DEBUG, 'Salmon: incoming post for user: '. $user_id);

        // TODO : Insert new $xml -> notice code

        switch ($this->act->verb)
        {
        case Activity::POST:
        case Activity::SHARE:
        case Activity::FAVORITE:
        case Activity::FOLLOW:
        }
    }
}
