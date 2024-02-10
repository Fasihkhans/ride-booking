<?php

namespace App\Constants;

class Constants
{
    const ACTIVE = 1;

    const INACTIVE = 0;

    const ACTIVE_VEHICLE = 1;

    const INACTIVE_VEHICLE = 2;

    const ACTIVE_DRIVER_ON_BREAK = 2;

    const BOOKING_WAITING = 0;

    const BOOKING_IN_PROGRESS = 1;

    const BOOKING_ACCEPTED = 2;

    const BOOKING_DECLINED = 3;

    const BOOKING_COMPLETED = 4;

    const BOOKING_NO_DRIVER_FOUND = 5;

    const BOOKING_CANCEL_BY_USER = 6;

    const BOOKING_TYPE_ON_DEMAND = 'OnDemand';

    const BOOKING_STOP_STATUS_ACTIVE = 1;

    const BOOKING_STOP_TYPE_PICKUP = 'pickUp';

    const BOOKING_STOP_TYPE_MID_STOP = 'middleStop';

    const BOOKING_STOP_TYPE_DROP_OFF = 'dropOff';

    const BOOKING_PAYMENT_PENDING = 'pending';

    const BOOKING_PAYMENT_PAID = 'paid';

    const BOOKING_PAYMENT_FAILED = 'failed';

    const BOOKING_PAYMENT_METHOD_CASH = 'cash';

    const BOOKING_PAYMENT_METHOD_CARD = 'card';
}
