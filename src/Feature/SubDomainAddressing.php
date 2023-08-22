<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Attribute;
use Robier\EmailNormalization\Email;

/**
 * Re-combine email so sub-domain part of domain will become name part.
 *
 * For example:
 *      foo@bar.test.com -> bar@test.com
 *
 * @see \Robier\EmailNormalization\Test\Feature\SubDomainAddressingTest
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class SubDomainAddressing implements Contract
{
    public function handle(Email $email): Email
    {
        if (mb_substr_count($email->domain(), '.') === 1) {
            // we are 100% there is no any subdomain
            return $email;
        }

        // failsafe, we can only have matched domain on DomainProvider type of provider
        if (!isset($email->meta()['matched-domain'])) {
            return $email;
        }

        if (in_array(
            strpos($email->domain(), $email->meta()['matched-domain']),
            [false, 0],
            true
        )) {
            return $email;
        }

        // extract name part of email that's currently in subdomain
        $subdomain = mb_substr(
            $email->domain(),
            0,
            // number needs to be negative so we cut from right to left and addition 1 is
            // here to remove additional `.` as it's an extra for separating subdomain and
            // domain
            (-1 * (mb_strlen($email->meta()['matched-domain']) + 1))
        );

        return new Email($subdomain, $email->meta()['matched-domain'], $email->meta());
    }
}
