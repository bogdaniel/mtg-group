<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Uid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206165220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT NOT NULL, uuid CHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, iso_alpha_two VARCHAR(2) NOT NULL, iso_alpha_three VARCHAR(3) NOT NULL, iso_numeric VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN country.uuid IS \'(DC2Type:uuid)\'');

        $countries = [
            'AD' =>
                [
                    'isoAlphaTwo' => 'AD',
                    'isoAlphaThree' => 'AND',
                    'numericKey' => '020',
                    'country' => 'Andorra',
                ],
            'AE' =>
                [
                    'isoAlphaTwo' => 'AE',
                    'isoAlphaThree' => 'ARE',
                    'numericKey' => 784,
                    'country' => 'United Arab Emirates',
                ],
            'AF' =>
                [
                    'isoAlphaTwo' => 'AF',
                    'isoAlphaThree' => 'AFG',
                    'numericKey' => '004',
                    'country' => 'Afghanistan',
                ],
            'AG' =>
                [
                    'isoAlphaTwo' => 'AG',
                    'isoAlphaThree' => 'ATG',
                    'numericKey' => '028',
                    'country' => 'Antigua and Barbuda',
                ],
            'AI' =>
                [
                    'isoAlphaTwo' => 'AI',
                    'isoAlphaThree' => 'AIA',
                    'numericKey' => 660,
                    'country' => 'Anguilla',
                ],
            'AL' =>
                [
                    'isoAlphaTwo' => 'AL',
                    'isoAlphaThree' => 'ALB',
                    'numericKey' => '008',
                    'country' => 'Albania',
                ],
            'AM' =>
                [
                    'isoAlphaTwo' => 'AM',
                    'isoAlphaThree' => 'ARM',
                    'numericKey' => '051',
                    'country' => 'Armenia',
                ],
            'AO' =>
                [
                    'isoAlphaTwo' => 'AO',
                    'isoAlphaThree' => 'AGO',
                    'numericKey' => '024',
                    'country' => 'Angola',
                ],
            'AQ' =>
                [
                    'isoAlphaTwo' => 'AQ',
                    'isoAlphaThree' => 'ATA',
                    'numericKey' => '010',
                    'country' => 'Antarctica',
                ],
            'AR' =>
                [
                    'isoAlphaTwo' => 'AR',
                    'isoAlphaThree' => 'ARG',
                    'numericKey' => '032',
                    'country' => 'Argentina',
                ],
            'AS' =>
                [
                    'isoAlphaTwo' => 'AS',
                    'isoAlphaThree' => 'ASM',
                    'numericKey' => '016',
                    'country' => 'American Samoa',
                ],
            'AT' =>
                [
                    'isoAlphaTwo' => 'AT',
                    'isoAlphaThree' => 'AUT',
                    'numericKey' => '040',
                    'country' => 'Austria',
                ],
            'AU' =>
                [
                    'isoAlphaTwo' => 'AU',
                    'isoAlphaThree' => 'AUS',
                    'numericKey' => '036',
                    'country' => 'Australia',
                ],
            'AW' =>
                [
                    'isoAlphaTwo' => 'AW',
                    'isoAlphaThree' => 'ABW',
                    'numericKey' => 533,
                    'country' => 'Aruba',
                ],
            'AX' =>
                [
                    'isoAlphaTwo' => 'AX',
                    'isoAlphaThree' => 'ALA',
                    'numericKey' => 248,
                    'country' => 'Åland Islands',
                ],
            'AZ' =>
                [
                    'isoAlphaTwo' => 'AZ',
                    'isoAlphaThree' => 'AZE',
                    'numericKey' => '031',
                    'country' => 'Azerbaijan',
                ],
            'BA' =>
                [
                    'isoAlphaTwo' => 'BA',
                    'isoAlphaThree' => 'BIH',
                    'numericKey' => '070',
                    'country' => 'Bosnia and Herzegovina',
                ],
            'BB' =>
                [
                    'isoAlphaTwo' => 'BB',
                    'isoAlphaThree' => 'BRB',
                    'numericKey' => '052',
                    'country' => 'Barbados',
                ],
            'BD' =>
                [
                    'isoAlphaTwo' => 'BD',
                    'isoAlphaThree' => 'BGD',
                    'numericKey' => '050',
                    'country' => 'Bangladesh',
                ],
            'BE' =>
                [
                    'isoAlphaTwo' => 'BE',
                    'isoAlphaThree' => 'BEL',
                    'numericKey' => '056',
                    'country' => 'Belgium',
                ],
            'BF' =>
                [
                    'isoAlphaTwo' => 'BF',
                    'isoAlphaThree' => 'BFA',
                    'numericKey' => 854,
                    'country' => 'Burkina Faso',
                ],
            'BG' =>
                [
                    'isoAlphaTwo' => 'BG',
                    'isoAlphaThree' => 'BGR',
                    'numericKey' => 100,
                    'country' => 'Bulgaria',
                ],
            'BH' =>
                [
                    'isoAlphaTwo' => 'BH',
                    'isoAlphaThree' => 'BHR',
                    'numericKey' => '048',
                    'country' => 'Bahrain',
                ],
            'BI' =>
                [
                    'isoAlphaTwo' => 'BI',
                    'isoAlphaThree' => 'BDI',
                    'numericKey' => 108,
                    'country' => 'Burundi',
                ],
            'BJ' =>
                [
                    'isoAlphaTwo' => 'BJ',
                    'isoAlphaThree' => 'BEN',
                    'numericKey' => 204,
                    'country' => 'Benin',
                ],
            'BL' =>
                [
                    'isoAlphaTwo' => 'BL',
                    'isoAlphaThree' => 'BLM',
                    'numericKey' => 652,
                    'country' => 'Saint Barthélemy',
                ],
            'BM' =>
                [
                    'isoAlphaTwo' => 'BM',
                    'isoAlphaThree' => 'BMU',
                    'numericKey' => '060',
                    'country' => 'Bermuda',
                ],
            'BN' =>
                [
                    'isoAlphaTwo' => 'BN',
                    'isoAlphaThree' => 'BRN',
                    'numericKey' => '096',
                    'country' => 'Brunei Darussalam',
                ],
            'BO' =>
                [
                    'isoAlphaTwo' => 'BO',
                    'isoAlphaThree' => 'BOL',
                    'numericKey' => '068',
                    'country' => 'Bolivia, Plurinational State of',
                ],
            'BQ' =>
                [
                    'isoAlphaTwo' => 'BQ',
                    'isoAlphaThree' => 'BES',
                    'numericKey' => 535,
                    'country' => 'Bonaire, Sint Eustatius and Saba',
                ],
            'BR' =>
                [
                    'isoAlphaTwo' => 'BR',
                    'isoAlphaThree' => 'BRA',
                    'numericKey' => '076',
                    'country' => 'Brazil',
                ],
            'BS' =>
                [
                    'isoAlphaTwo' => 'BS',
                    'isoAlphaThree' => 'BHS',
                    'numericKey' => '044',
                    'country' => 'Bahamas',
                ],
            'BT' =>
                [
                    'isoAlphaTwo' => 'BT',
                    'isoAlphaThree' => 'BTN',
                    'numericKey' => '064',
                    'country' => 'Bhutan',
                ],
            'BV' =>
                [
                    'isoAlphaTwo' => 'BV',
                    'isoAlphaThree' => 'BVT',
                    'numericKey' => '074',
                    'country' => 'Bouvet Island',
                ],
            'BW' =>
                [
                    'isoAlphaTwo' => 'BW',
                    'isoAlphaThree' => 'BWA',
                    'numericKey' => '072',
                    'country' => 'Botswana',
                ],
            'BY' =>
                [
                    'isoAlphaTwo' => 'BY',
                    'isoAlphaThree' => 'BLR',
                    'numericKey' => 112,
                    'country' => 'Belarus',
                ],
            'BZ' =>
                [
                    'isoAlphaTwo' => 'BZ',
                    'isoAlphaThree' => 'BLZ',
                    'numericKey' => '084',
                    'country' => 'Belize',
                ],
            'CA' =>
                [
                    'isoAlphaTwo' => 'CA',
                    'isoAlphaThree' => 'CAN',
                    'numericKey' => 124,
                    'country' => 'Canada',
                ],
            'CC' =>
                [
                    'isoAlphaTwo' => 'CC',
                    'isoAlphaThree' => 'CCK',
                    'numericKey' => 166,
                    'country' => 'Cocos (Keeling) Islands',
                ],
            'CD' =>
                [
                    'isoAlphaTwo' => 'CD',
                    'isoAlphaThree' => 'COD',
                    'numericKey' => 180,
                    'country' => 'Congo, the Democratic Republic of the',
                ],
            'CF' =>
                [
                    'isoAlphaTwo' => 'CF',
                    'isoAlphaThree' => 'CAF',
                    'numericKey' => 140,
                    'country' => 'Central African Republic',
                ],
            'CG' =>
                [
                    'isoAlphaTwo' => 'CG',
                    'isoAlphaThree' => 'COG',
                    'numericKey' => 178,
                    'country' => 'Congo',
                ],
            'CH' =>
                [
                    'isoAlphaTwo' => 'CH',
                    'isoAlphaThree' => 'CHE',
                    'numericKey' => 756,
                    'country' => 'Switzerland',
                ],
            'CI' =>
                [
                    'isoAlphaTwo' => 'CI',
                    'isoAlphaThree' => 'CIV',
                    'numericKey' => 384,
                    'country' => 'Côte d\'Ivoire',
                ],
            'CK' =>
                [
                    'isoAlphaTwo' => 'CK',
                    'isoAlphaThree' => 'COK',
                    'numericKey' => 184,
                    'country' => 'Cook Islands',
                ],
            'CL' =>
                [
                    'isoAlphaTwo' => 'CL',
                    'isoAlphaThree' => 'CHL',
                    'numericKey' => 152,
                    'country' => 'Chile',
                ],
            'CM' =>
                [
                    'isoAlphaTwo' => 'CM',
                    'isoAlphaThree' => 'CMR',
                    'numericKey' => 120,
                    'country' => 'Cameroon',
                ],
            'CN' =>
                [
                    'isoAlphaTwo' => 'CN',
                    'isoAlphaThree' => 'CHN',
                    'numericKey' => 156,
                    'country' => 'China',
                ],
            'CO' =>
                [
                    'isoAlphaTwo' => 'CO',
                    'isoAlphaThree' => 'COL',
                    'numericKey' => 170,
                    'country' => 'Colombia',
                ],
            'CR' =>
                [
                    'isoAlphaTwo' => 'CR',
                    'isoAlphaThree' => 'CRI',
                    'numericKey' => 188,
                    'country' => 'Costa Rica',
                ],
            'CU' =>
                [
                    'isoAlphaTwo' => 'CU',
                    'isoAlphaThree' => 'CUB',
                    'numericKey' => 192,
                    'country' => 'Cuba',
                ],
            'CV' =>
                [
                    'isoAlphaTwo' => 'CV',
                    'isoAlphaThree' => 'CPV',
                    'numericKey' => 132,
                    'country' => 'Cabo Verde',
                ],
            'CW' =>
                [
                    'isoAlphaTwo' => 'CW',
                    'isoAlphaThree' => 'CUW',
                    'numericKey' => 531,
                    'country' => 'Curaçao',
                ],
            'CX' =>
                [
                    'isoAlphaTwo' => 'CX',
                    'isoAlphaThree' => 'CXR',
                    'numericKey' => 162,
                    'country' => 'Christmas Island',
                ],
            'CY' =>
                [
                    'isoAlphaTwo' => 'CY',
                    'isoAlphaThree' => 'CYP',
                    'numericKey' => 196,
                    'country' => 'Cyprus',
                ],
            'CZ' =>
                [
                    'isoAlphaTwo' => 'CZ',
                    'isoAlphaThree' => 'CZE',
                    'numericKey' => 203,
                    'country' => 'Czechia',
                ],
            'DE' =>
                [
                    'isoAlphaTwo' => 'DE',
                    'isoAlphaThree' => 'DEU',
                    'numericKey' => 276,
                    'country' => 'Germany',
                ],
            'DJ' =>
                [
                    'isoAlphaTwo' => 'DJ',
                    'isoAlphaThree' => 'DJI',
                    'numericKey' => 262,
                    'country' => 'Djibouti',
                ],
            'DK' =>
                [
                    'isoAlphaTwo' => 'DK',
                    'isoAlphaThree' => 'DNK',
                    'numericKey' => 208,
                    'country' => 'Denmark',
                ],
            'DM' =>
                [
                    'isoAlphaTwo' => 'DM',
                    'isoAlphaThree' => 'DMA',
                    'numericKey' => 212,
                    'country' => 'Dominica',
                ],
            'DO' =>
                [
                    'isoAlphaTwo' => 'DO',
                    'isoAlphaThree' => 'DOM',
                    'numericKey' => 214,
                    'country' => 'Dominican Republic',
                ],
            'DZ' =>
                [
                    'isoAlphaTwo' => 'DZ',
                    'isoAlphaThree' => 'DZA',
                    'numericKey' => '012',
                    'country' => 'Algeria',
                ],
            'EC' =>
                [
                    'isoAlphaTwo' => 'EC',
                    'isoAlphaThree' => 'ECU',
                    'numericKey' => 218,
                    'country' => 'Ecuador',
                ],
            'EE' =>
                [
                    'isoAlphaTwo' => 'EE',
                    'isoAlphaThree' => 'EST',
                    'numericKey' => 233,
                    'country' => 'Estonia',
                ],
            'EG' =>
                [
                    'isoAlphaTwo' => 'EG',
                    'isoAlphaThree' => 'EGY',
                    'numericKey' => 818,
                    'country' => 'Egypt',
                ],
            'EH' =>
                [
                    'isoAlphaTwo' => 'EH',
                    'isoAlphaThree' => 'ESH',
                    'numericKey' => 732,
                    'country' => 'Western Sahara',
                ],
            'ER' =>
                [
                    'isoAlphaTwo' => 'ER',
                    'isoAlphaThree' => 'ERI',
                    'numericKey' => 232,
                    'country' => 'Eritrea',
                ],
            'ES' =>
                [
                    'isoAlphaTwo' => 'ES',
                    'isoAlphaThree' => 'ESP',
                    'numericKey' => 724,
                    'country' => 'Spain',
                ],
            'ET' =>
                [
                    'isoAlphaTwo' => 'ET',
                    'isoAlphaThree' => 'ETH',
                    'numericKey' => 231,
                    'country' => 'Ethiopia',
                ],
            'FI' =>
                [
                    'isoAlphaTwo' => 'FI',
                    'isoAlphaThree' => 'FIN',
                    'numericKey' => 246,
                    'country' => 'Finland',
                ],
            'FJ' =>
                [
                    'isoAlphaTwo' => 'FJ',
                    'isoAlphaThree' => 'FJI',
                    'numericKey' => 242,
                    'country' => 'Fiji',
                ],
            'FK' =>
                [
                    'isoAlphaTwo' => 'FK',
                    'isoAlphaThree' => 'FLK',
                    'numericKey' => 238,
                    'country' => 'Falkland Islands (Malvinas)',
                ],
            'FM' =>
                [
                    'isoAlphaTwo' => 'FM',
                    'isoAlphaThree' => 'FSM',
                    'numericKey' => 583,
                    'country' => 'Micronesia, Federated States of',
                ],
            'FO' =>
                [
                    'isoAlphaTwo' => 'FO',
                    'isoAlphaThree' => 'FRO',
                    'numericKey' => 234,
                    'country' => 'Faroe Islands',
                ],
            'FR' =>
                [
                    'isoAlphaTwo' => 'FR',
                    'isoAlphaThree' => 'FRA',
                    'numericKey' => 250,
                    'country' => 'France',
                ],
            'GA' =>
                [
                    'isoAlphaTwo' => 'GA',
                    'isoAlphaThree' => 'GAB',
                    'numericKey' => 266,
                    'country' => 'Gabon',
                ],
            'GB' =>
                [
                    'isoAlphaTwo' => 'GB',
                    'isoAlphaThree' => 'GBR',
                    'numericKey' => 826,
                    'country' => 'United Kingdom of Great Britain and Northern Ireland',
                ],
            'GD' =>
                [
                    'isoAlphaTwo' => 'GD',
                    'isoAlphaThree' => 'GRD',
                    'numericKey' => 308,
                    'country' => 'Grenada',
                ],
            'GE' =>
                [
                    'isoAlphaTwo' => 'GE',
                    'isoAlphaThree' => 'GEO',
                    'numericKey' => 268,
                    'country' => 'Georgia',
                ],
            'GF' =>
                [
                    'isoAlphaTwo' => 'GF',
                    'isoAlphaThree' => 'GUF',
                    'numericKey' => 254,
                    'country' => 'French Guiana',
                ],
            'GG' =>
                [
                    'isoAlphaTwo' => 'GG',
                    'isoAlphaThree' => 'GGY',
                    'numericKey' => 831,
                    'country' => 'Guernsey',
                ],
            'GH' =>
                [
                    'isoAlphaTwo' => 'GH',
                    'isoAlphaThree' => 'GHA',
                    'numericKey' => 288,
                    'country' => 'Ghana',
                ],
            'GI' =>
                [
                    'isoAlphaTwo' => 'GI',
                    'isoAlphaThree' => 'GIB',
                    'numericKey' => 292,
                    'country' => 'Gibraltar',
                ],
            'GL' =>
                [
                    'isoAlphaTwo' => 'GL',
                    'isoAlphaThree' => 'GRL',
                    'numericKey' => 304,
                    'country' => 'Greenland',
                ],
            'GM' =>
                [
                    'isoAlphaTwo' => 'GM',
                    'isoAlphaThree' => 'GMB',
                    'numericKey' => 270,
                    'country' => 'Gambia',
                ],
            'GN' =>
                [
                    'isoAlphaTwo' => 'GN',
                    'isoAlphaThree' => 'GIN',
                    'numericKey' => 324,
                    'country' => 'Guinea',
                ],
            'GP' =>
                [
                    'isoAlphaTwo' => 'GP',
                    'isoAlphaThree' => 'GLP',
                    'numericKey' => 312,
                    'country' => 'Guadeloupe',
                ],
            'GQ' =>
                [
                    'isoAlphaTwo' => 'GQ',
                    'isoAlphaThree' => 'GNQ',
                    'numericKey' => 226,
                    'country' => 'Equatorial Guinea',
                ],
            'GR' =>
                [
                    'isoAlphaTwo' => 'GR',
                    'isoAlphaThree' => 'GRC',
                    'numericKey' => 300,
                    'country' => 'Greece',
                ],
            'GS' =>
                [
                    'isoAlphaTwo' => 'GS',
                    'isoAlphaThree' => 'SGS',
                    'numericKey' => 239,
                    'country' => 'South Georgia and the South Sandwich Islands',
                ],
            'GT' =>
                [
                    'isoAlphaTwo' => 'GT',
                    'isoAlphaThree' => 'GTM',
                    'numericKey' => 320,
                    'country' => 'Guatemala',
                ],
            'GU' =>
                [
                    'isoAlphaTwo' => 'GU',
                    'isoAlphaThree' => 'GUM',
                    'numericKey' => 316,
                    'country' => 'Guam',
                ],
            'GW' =>
                [
                    'isoAlphaTwo' => 'GW',
                    'isoAlphaThree' => 'GNB',
                    'numericKey' => 624,
                    'country' => 'Guinea-Bissau',
                ],
            'GY' =>
                [
                    'isoAlphaTwo' => 'GY',
                    'isoAlphaThree' => 'GUY',
                    'numericKey' => 328,
                    'country' => 'Guyana',
                ],
            'HK' =>
                [
                    'isoAlphaTwo' => 'HK',
                    'isoAlphaThree' => 'HKG',
                    'numericKey' => 344,
                    'country' => 'Hong Kong',
                ],
            'HM' =>
                [
                    'isoAlphaTwo' => 'HM',
                    'isoAlphaThree' => 'HMD',
                    'numericKey' => 334,
                    'country' => 'Heard Island and McDonald Islands',
                ],
            'HN' =>
                [
                    'isoAlphaTwo' => 'HN',
                    'isoAlphaThree' => 'HND',
                    'numericKey' => 340,
                    'country' => 'Honduras',
                ],
            'HR' =>
                [
                    'isoAlphaTwo' => 'HR',
                    'isoAlphaThree' => 'HRV',
                    'numericKey' => 191,
                    'country' => 'Croatia',
                ],
            'HT' =>
                [
                    'isoAlphaTwo' => 'HT',
                    'isoAlphaThree' => 'HTI',
                    'numericKey' => 332,
                    'country' => 'Haiti',
                ],
            'HU' =>
                [
                    'isoAlphaTwo' => 'HU',
                    'isoAlphaThree' => 'HUN',
                    'numericKey' => 348,
                    'country' => 'Hungary',
                ],
            'ID' =>
                [
                    'isoAlphaTwo' => 'ID',
                    'isoAlphaThree' => 'IDN',
                    'numericKey' => 360,
                    'country' => 'Indonesia',
                ],
            'IE' =>
                [
                    'isoAlphaTwo' => 'IE',
                    'isoAlphaThree' => 'IRL',
                    'numericKey' => 372,
                    'country' => 'Ireland',
                ],
            'IL' =>
                [
                    'isoAlphaTwo' => 'IL',
                    'isoAlphaThree' => 'ISR',
                    'numericKey' => 376,
                    'country' => 'Israel',
                ],
            'IM' =>
                [
                    'isoAlphaTwo' => 'IM',
                    'isoAlphaThree' => 'IMN',
                    'numericKey' => 833,
                    'country' => 'Isle of Man',
                ],
            'IN' =>
                [
                    'isoAlphaTwo' => 'IN',
                    'isoAlphaThree' => 'IND',
                    'numericKey' => 356,
                    'country' => 'India',
                ],
            'IO' =>
                [
                    'isoAlphaTwo' => 'IO',
                    'isoAlphaThree' => 'IOT',
                    'numericKey' => '086',
                    'country' => 'British Indian Ocean Territory',
                ],
            'IQ' =>
                [
                    'isoAlphaTwo' => 'IQ',
                    'isoAlphaThree' => 'IRQ',
                    'numericKey' => 368,
                    'country' => 'Iraq',
                ],
            'IR' =>
                [
                    'isoAlphaTwo' => 'IR',
                    'isoAlphaThree' => 'IRN',
                    'numericKey' => 364,
                    'country' => 'Iran, Islamic Republic of',
                ],
            'IS' =>
                [
                    'isoAlphaTwo' => 'IS',
                    'isoAlphaThree' => 'ISL',
                    'numericKey' => 352,
                    'country' => 'Iceland',
                ],
            'IT' =>
                [
                    'isoAlphaTwo' => 'IT',
                    'isoAlphaThree' => 'ITA',
                    'numericKey' => 380,
                    'country' => 'Italy',
                ],
            'JE' =>
                [
                    'isoAlphaTwo' => 'JE',
                    'isoAlphaThree' => 'JEY',
                    'numericKey' => 832,
                    'country' => 'Jersey',
                ],
            'JM' =>
                [
                    'isoAlphaTwo' => 'JM',
                    'isoAlphaThree' => 'JAM',
                    'numericKey' => 388,
                    'country' => 'Jamaica',
                ],
            'JO' =>
                [
                    'isoAlphaTwo' => 'JO',
                    'isoAlphaThree' => 'JOR',
                    'numericKey' => 400,
                    'country' => 'Jordan',
                ],
            'JP' =>
                [
                    'isoAlphaTwo' => 'JP',
                    'isoAlphaThree' => 'JPN',
                    'numericKey' => 392,
                    'country' => 'Japan',
                ],
            'KE' =>
                [
                    'isoAlphaTwo' => 'KE',
                    'isoAlphaThree' => 'KEN',
                    'numericKey' => 404,
                    'country' => 'Kenya',
                ],
            'KG' =>
                [
                    'isoAlphaTwo' => 'KG',
                    'isoAlphaThree' => 'KGZ',
                    'numericKey' => 417,
                    'country' => 'Kyrgyzstan',
                ],
            'KH' =>
                [
                    'isoAlphaTwo' => 'KH',
                    'isoAlphaThree' => 'KHM',
                    'numericKey' => 116,
                    'country' => 'Cambodia',
                ],
            'KI' =>
                [
                    'isoAlphaTwo' => 'KI',
                    'isoAlphaThree' => 'KIR',
                    'numericKey' => 296,
                    'country' => 'Kiribati',
                ],
            'KM' =>
                [
                    'isoAlphaTwo' => 'KM',
                    'isoAlphaThree' => 'COM',
                    'numericKey' => 174,
                    'country' => 'Comoros',
                ],
            'KN' =>
                [
                    'isoAlphaTwo' => 'KN',
                    'isoAlphaThree' => 'KNA',
                    'numericKey' => 659,
                    'country' => 'Saint Kitts and Nevis',
                ],
            'KP' =>
                [
                    'isoAlphaTwo' => 'KP',
                    'isoAlphaThree' => 'PRK',
                    'numericKey' => 408,
                    'country' => 'Korea, Democratic People\'s Republic of',
                ],
            'KR' =>
                [
                    'isoAlphaTwo' => 'KR',
                    'isoAlphaThree' => 'KOR',
                    'numericKey' => 410,
                    'country' => 'Korea, Republic of',
                ],
            'KW' =>
                [
                    'isoAlphaTwo' => 'KW',
                    'isoAlphaThree' => 'KWT',
                    'numericKey' => 414,
                    'country' => 'Kuwait',
                ],
            'KY' =>
                [
                    'isoAlphaTwo' => 'KY',
                    'isoAlphaThree' => 'CYM',
                    'numericKey' => 136,
                    'country' => 'Cayman Islands',
                ],
            'KZ' =>
                [
                    'isoAlphaTwo' => 'KZ',
                    'isoAlphaThree' => 'KAZ',
                    'numericKey' => 398,
                    'country' => 'Kazakhstan',
                ],
            'LA' =>
                [
                    'isoAlphaTwo' => 'LA',
                    'isoAlphaThree' => 'LAO',
                    'numericKey' => 418,
                    'country' => 'Lao People\'s Democratic Republic',
                ],
            'LB' =>
                [
                    'isoAlphaTwo' => 'LB',
                    'isoAlphaThree' => 'LBN',
                    'numericKey' => 422,
                    'country' => 'Lebanon',
                ],
            'LC' =>
                [
                    'isoAlphaTwo' => 'LC',
                    'isoAlphaThree' => 'LCA',
                    'numericKey' => 662,
                    'country' => 'Saint Lucia',
                ],
            'LI' =>
                [
                    'isoAlphaTwo' => 'LI',
                    'isoAlphaThree' => 'LIE',
                    'numericKey' => 438,
                    'country' => 'Liechtenstein',
                ],
            'LK' =>
                [
                    'isoAlphaTwo' => 'LK',
                    'isoAlphaThree' => 'LKA',
                    'numericKey' => 144,
                    'country' => 'Sri Lanka',
                ],
            'LR' =>
                [
                    'isoAlphaTwo' => 'LR',
                    'isoAlphaThree' => 'LBR',
                    'numericKey' => 430,
                    'country' => 'Liberia',
                ],
            'LS' =>
                [
                    'isoAlphaTwo' => 'LS',
                    'isoAlphaThree' => 'LSO',
                    'numericKey' => 426,
                    'country' => 'Lesotho',
                ],
            'LT' =>
                [
                    'isoAlphaTwo' => 'LT',
                    'isoAlphaThree' => 'LTU',
                    'numericKey' => 440,
                    'country' => 'Lithuania',
                ],
            'LU' =>
                [
                    'isoAlphaTwo' => 'LU',
                    'isoAlphaThree' => 'LUX',
                    'numericKey' => 442,
                    'country' => 'Luxembourg',
                ],
            'LV' =>
                [
                    'isoAlphaTwo' => 'LV',
                    'isoAlphaThree' => 'LVA',
                    'numericKey' => 428,
                    'country' => 'Latvia',
                ],
            'LY' =>
                [
                    'isoAlphaTwo' => 'LY',
                    'isoAlphaThree' => 'LBY',
                    'numericKey' => 434,
                    'country' => 'Libya',
                ],
            'MA' =>
                [
                    'isoAlphaTwo' => 'MA',
                    'isoAlphaThree' => 'MAR',
                    'numericKey' => 504,
                    'country' => 'Morocco',
                ],
            'MC' =>
                [
                    'isoAlphaTwo' => 'MC',
                    'isoAlphaThree' => 'MCO',
                    'numericKey' => 492,
                    'country' => 'Monaco',
                ],
            'MD' =>
                [
                    'isoAlphaTwo' => 'MD',
                    'isoAlphaThree' => 'MDA',
                    'numericKey' => 498,
                    'country' => 'Moldova, Republic of',
                ],
            'ME' =>
                [
                    'isoAlphaTwo' => 'ME',
                    'isoAlphaThree' => 'MNE',
                    'numericKey' => 499,
                    'country' => 'Montenegro',
                ],
            'MF' =>
                [
                    'isoAlphaTwo' => 'MF',
                    'isoAlphaThree' => 'MAF',
                    'numericKey' => 663,
                    'country' => 'Saint Martin (French part)',
                ],
            'MG' =>
                [
                    'isoAlphaTwo' => 'MG',
                    'isoAlphaThree' => 'MDG',
                    'numericKey' => 450,
                    'country' => 'Madagascar',
                ],
            'MH' =>
                [
                    'isoAlphaTwo' => 'MH',
                    'isoAlphaThree' => 'MHL',
                    'numericKey' => 584,
                    'country' => 'Marshall Islands',
                ],
            'MK' =>
                [
                    'isoAlphaTwo' => 'MK',
                    'isoAlphaThree' => 'MKD',
                    'numericKey' => 807,
                    'country' => 'Macedonia, the former Yugoslav Republic of',
                ],
            'ML' =>
                [
                    'isoAlphaTwo' => 'ML',
                    'isoAlphaThree' => 'MLI',
                    'numericKey' => 466,
                    'country' => 'Mali',
                ],
            'MM' =>
                [
                    'isoAlphaTwo' => 'MM',
                    'isoAlphaThree' => 'MMR',
                    'numericKey' => 104,
                    'country' => 'Myanmar',
                ],
            'MN' =>
                [
                    'isoAlphaTwo' => 'MN',
                    'isoAlphaThree' => 'MNG',
                    'numericKey' => 496,
                    'country' => 'Mongolia',
                ],
            'MO' =>
                [
                    'isoAlphaTwo' => 'MO',
                    'isoAlphaThree' => 'MAC',
                    'numericKey' => 446,
                    'country' => 'Macao',
                ],
            'MP' =>
                [
                    'isoAlphaTwo' => 'MP',
                    'isoAlphaThree' => 'MNP',
                    'numericKey' => 580,
                    'country' => 'Northern Mariana Islands',
                ],
            'MQ' =>
                [
                    'isoAlphaTwo' => 'MQ',
                    'isoAlphaThree' => 'MTQ',
                    'numericKey' => 474,
                    'country' => 'Martinique',
                ],
            'MR' =>
                [
                    'isoAlphaTwo' => 'MR',
                    'isoAlphaThree' => 'MRT',
                    'numericKey' => 478,
                    'country' => 'Mauritania',
                ],
            'MS' =>
                [
                    'isoAlphaTwo' => 'MS',
                    'isoAlphaThree' => 'MSR',
                    'numericKey' => 500,
                    'country' => 'Montserrat',
                ],
            'MT' =>
                [
                    'isoAlphaTwo' => 'MT',
                    'isoAlphaThree' => 'MLT',
                    'numericKey' => 470,
                    'country' => 'Malta',
                ],
            'MU' =>
                [
                    'isoAlphaTwo' => 'MU',
                    'isoAlphaThree' => 'MUS',
                    'numericKey' => 480,
                    'country' => 'Mauritius',
                ],
            'MV' =>
                [
                    'isoAlphaTwo' => 'MV',
                    'isoAlphaThree' => 'MDV',
                    'numericKey' => 462,
                    'country' => 'Maldives',
                ],
            'MW' =>
                [
                    'isoAlphaTwo' => 'MW',
                    'isoAlphaThree' => 'MWI',
                    'numericKey' => 454,
                    'country' => 'Malawi',
                ],
            'MX' =>
                [
                    'isoAlphaTwo' => 'MX',
                    'isoAlphaThree' => 'MEX',
                    'numericKey' => 484,
                    'country' => 'Mexico',
                ],
            'MY' =>
                [
                    'isoAlphaTwo' => 'MY',
                    'isoAlphaThree' => 'MYS',
                    'numericKey' => 458,
                    'country' => 'Malaysia',
                ],
            'MZ' =>
                [
                    'isoAlphaTwo' => 'MZ',
                    'isoAlphaThree' => 'MOZ',
                    'numericKey' => 508,
                    'country' => 'Mozambique',
                ],
            'NA' =>
                [
                    'isoAlphaTwo' => 'NA',
                    'isoAlphaThree' => 'NAM',
                    'numericKey' => 516,
                    'country' => 'Namibia',
                ],
            'NC' =>
                [
                    'isoAlphaTwo' => 'NC',
                    'isoAlphaThree' => 'NCL',
                    'numericKey' => 540,
                    'country' => 'New Caledonia',
                ],
            'NE' =>
                [
                    'isoAlphaTwo' => 'NE',
                    'isoAlphaThree' => 'NER',
                    'numericKey' => 562,
                    'country' => 'Niger',
                ],
            'NF' =>
                [
                    'isoAlphaTwo' => 'NF',
                    'isoAlphaThree' => 'NFK',
                    'numericKey' => 574,
                    'country' => 'Norfolk Island',
                ],
            'NG' =>
                [
                    'isoAlphaTwo' => 'NG',
                    'isoAlphaThree' => 'NGA',
                    'numericKey' => 566,
                    'country' => 'Nigeria',
                ],
            'NI' =>
                [
                    'isoAlphaTwo' => 'NI',
                    'isoAlphaThree' => 'NIC',
                    'numericKey' => 558,
                    'country' => 'Nicaragua',
                ],
            'NL' =>
                [
                    'isoAlphaTwo' => 'NL',
                    'isoAlphaThree' => 'NLD',
                    'numericKey' => 528,
                    'country' => 'Netherlands',
                ],
            'NO' =>
                [
                    'isoAlphaTwo' => 'NO',
                    'isoAlphaThree' => 'NOR',
                    'numericKey' => 578,
                    'country' => 'Norway',
                ],
            'NP' =>
                [
                    'isoAlphaTwo' => 'NP',
                    'isoAlphaThree' => 'NPL',
                    'numericKey' => 524,
                    'country' => 'Nepal',
                ],
            'NR' =>
                [
                    'isoAlphaTwo' => 'NR',
                    'isoAlphaThree' => 'NRU',
                    'numericKey' => 520,
                    'country' => 'Nauru',
                ],
            'NU' =>
                [
                    'isoAlphaTwo' => 'NU',
                    'isoAlphaThree' => 'NIU',
                    'numericKey' => 570,
                    'country' => 'Niue',
                ],
            'NZ' =>
                [
                    'isoAlphaTwo' => 'NZ',
                    'isoAlphaThree' => 'NZL',
                    'numericKey' => 554,
                    'country' => 'New Zealand',
                ],
            'OM' =>
                [
                    'isoAlphaTwo' => 'OM',
                    'isoAlphaThree' => 'OMN',
                    'numericKey' => 512,
                    'country' => 'Oman',
                ],
            'PA' =>
                [
                    'isoAlphaTwo' => 'PA',
                    'isoAlphaThree' => 'PAN',
                    'numericKey' => 591,
                    'country' => 'Panama',
                ],
            'PE' =>
                [
                    'isoAlphaTwo' => 'PE',
                    'isoAlphaThree' => 'PER',
                    'numericKey' => 604,
                    'country' => 'Peru',
                ],
            'PF' =>
                [
                    'isoAlphaTwo' => 'PF',
                    'isoAlphaThree' => 'PYF',
                    'numericKey' => 258,
                    'country' => 'French Polynesia',
                ],
            'PG' =>
                [
                    'isoAlphaTwo' => 'PG',
                    'isoAlphaThree' => 'PNG',
                    'numericKey' => 598,
                    'country' => 'Papua New Guinea',
                ],
            'PH' =>
                [
                    'isoAlphaTwo' => 'PH',
                    'isoAlphaThree' => 'PHL',
                    'numericKey' => 608,
                    'country' => 'Philippines',
                ],
            'PK' =>
                [
                    'isoAlphaTwo' => 'PK',
                    'isoAlphaThree' => 'PAK',
                    'numericKey' => 586,
                    'country' => 'Pakistan',
                ],
            'PL' =>
                [
                    'isoAlphaTwo' => 'PL',
                    'isoAlphaThree' => 'POL',
                    'numericKey' => 616,
                    'country' => 'Poland',
                ],
            'PM' =>
                [
                    'isoAlphaTwo' => 'PM',
                    'isoAlphaThree' => 'SPM',
                    'numericKey' => 666,
                    'country' => 'Saint Pierre and Miquelon',
                ],
            'PN' =>
                [
                    'isoAlphaTwo' => 'PN',
                    'isoAlphaThree' => 'PCN',
                    'numericKey' => 612,
                    'country' => 'Pitcairn',
                ],
            'PR' =>
                [
                    'isoAlphaTwo' => 'PR',
                    'isoAlphaThree' => 'PRI',
                    'numericKey' => 630,
                    'country' => 'Puerto Rico',
                ],
            'PS' =>
                [
                    'isoAlphaTwo' => 'PS',
                    'isoAlphaThree' => 'PSE',
                    'numericKey' => 275,
                    'country' => 'Palestine, State of',
                ],
            'PT' =>
                [
                    'isoAlphaTwo' => 'PT',
                    'isoAlphaThree' => 'PRT',
                    'numericKey' => 620,
                    'country' => 'Portugal',
                ],
            'PW' =>
                [
                    'isoAlphaTwo' => 'PW',
                    'isoAlphaThree' => 'PLW',
                    'numericKey' => 585,
                    'country' => 'Palau',
                ],
            'PY' =>
                [
                    'isoAlphaTwo' => 'PY',
                    'isoAlphaThree' => 'PRY',
                    'numericKey' => 600,
                    'country' => 'Paraguay',
                ],
            'QA' =>
                [
                    'isoAlphaTwo' => 'QA',
                    'isoAlphaThree' => 'QAT',
                    'numericKey' => 634,
                    'country' => 'Qatar',
                ],
            'RE' =>
                [
                    'isoAlphaTwo' => 'RE',
                    'isoAlphaThree' => 'REU',
                    'numericKey' => 638,
                    'country' => 'Réunion',
                ],
            'RO' =>
                [
                    'isoAlphaTwo' => 'RO',
                    'isoAlphaThree' => 'ROU',
                    'numericKey' => 642,
                    'country' => 'Romania',
                ],
            'RS' =>
                [
                    'isoAlphaTwo' => 'RS',
                    'isoAlphaThree' => 'SRB',
                    'numericKey' => 688,
                    'country' => 'Serbia',
                ],
            'RU' =>
                [
                    'isoAlphaTwo' => 'RU',
                    'isoAlphaThree' => 'RUS',
                    'numericKey' => 643,
                    'country' => 'Russian Federation',
                ],
            'RW' =>
                [
                    'isoAlphaTwo' => 'RW',
                    'isoAlphaThree' => 'RWA',
                    'numericKey' => 646,
                    'country' => 'Rwanda',
                ],
            'SA' =>
                [
                    'isoAlphaTwo' => 'SA',
                    'isoAlphaThree' => 'SAU',
                    'numericKey' => 682,
                    'country' => 'Saudi Arabia',
                ],
            'SB' =>
                [
                    'isoAlphaTwo' => 'SB',
                    'isoAlphaThree' => 'SLB',
                    'numericKey' => '090',
                    'country' => 'Solomon Islands',
                ],
            'SC' =>
                [
                    'isoAlphaTwo' => 'SC',
                    'isoAlphaThree' => 'SYC',
                    'numericKey' => 690,
                    'country' => 'Seychelles',
                ],
            'SD' =>
                [
                    'isoAlphaTwo' => 'SD',
                    'isoAlphaThree' => 'SDN',
                    'numericKey' => 729,
                    'country' => 'Sudan',
                ],
            'SE' =>
                [
                    'isoAlphaTwo' => 'SE',
                    'isoAlphaThree' => 'SWE',
                    'numericKey' => 752,
                    'country' => 'Sweden',
                ],
            'SG' =>
                [
                    'isoAlphaTwo' => 'SG',
                    'isoAlphaThree' => 'SGP',
                    'numericKey' => 702,
                    'country' => 'Singapore',
                ],
            'SH' =>
                [
                    'isoAlphaTwo' => 'SH',
                    'isoAlphaThree' => 'SHN',
                    'numericKey' => 654,
                    'country' => 'Saint Helena, Ascension and Tristan da Cunha',
                ],
            'SI' =>
                [
                    'isoAlphaTwo' => 'SI',
                    'isoAlphaThree' => 'SVN',
                    'numericKey' => 705,
                    'country' => 'Slovenia',
                ],
            'SJ' =>
                [
                    'isoAlphaTwo' => 'SJ',
                    'isoAlphaThree' => 'SJM',
                    'numericKey' => 744,
                    'country' => 'Svalbard and Jan Mayen',
                ],
            'SK' =>
                [
                    'isoAlphaTwo' => 'SK',
                    'isoAlphaThree' => 'SVK',
                    'numericKey' => 703,
                    'country' => 'Slovakia',
                ],
            'SL' =>
                [
                    'isoAlphaTwo' => 'SL',
                    'isoAlphaThree' => 'SLE',
                    'numericKey' => 694,
                    'country' => 'Sierra Leone',
                ],
            'SM' =>
                [
                    'isoAlphaTwo' => 'SM',
                    'isoAlphaThree' => 'SMR',
                    'numericKey' => 674,
                    'country' => 'San Marino',
                ],
            'SN' =>
                [
                    'isoAlphaTwo' => 'SN',
                    'isoAlphaThree' => 'SEN',
                    'numericKey' => 686,
                    'country' => 'Senegal',
                ],
            'SO' =>
                [
                    'isoAlphaTwo' => 'SO',
                    'isoAlphaThree' => 'SOM',
                    'numericKey' => 706,
                    'country' => 'Somalia',
                ],
            'SR' =>
                [
                    'isoAlphaTwo' => 'SR',
                    'isoAlphaThree' => 'SUR',
                    'numericKey' => 740,
                    'country' => 'Suriname',
                ],
            'SS' =>
                [
                    'isoAlphaTwo' => 'SS',
                    'isoAlphaThree' => 'SSD',
                    'numericKey' => 728,
                    'country' => 'South Sudan',
                ],
            'ST' =>
                [
                    'isoAlphaTwo' => 'ST',
                    'isoAlphaThree' => 'STP',
                    'numericKey' => 678,
                    'country' => 'Sao Tome and Principe',
                ],
            'SV' =>
                [
                    'isoAlphaTwo' => 'SV',
                    'isoAlphaThree' => 'SLV',
                    'numericKey' => 222,
                    'country' => 'El Salvador',
                ],
            'SX' =>
                [
                    'isoAlphaTwo' => 'SX',
                    'isoAlphaThree' => 'SXM',
                    'numericKey' => 534,
                    'country' => 'Sint Maarten (Dutch part)',
                ],
            'SY' =>
                [
                    'isoAlphaTwo' => 'SY',
                    'isoAlphaThree' => 'SYR',
                    'numericKey' => 760,
                    'country' => 'Syrian Arab Republic',
                ],
            'SZ' =>
                [
                    'isoAlphaTwo' => 'SZ',
                    'isoAlphaThree' => 'SWZ',
                    'numericKey' => 748,
                    'country' => 'Eswatini',
                ],
            'TC' =>
                [
                    'isoAlphaTwo' => 'TC',
                    'isoAlphaThree' => 'TCA',
                    'numericKey' => 796,
                    'country' => 'Turks and Caicos Islands',
                ],
            'TD' =>
                [
                    'isoAlphaTwo' => 'TD',
                    'isoAlphaThree' => 'TCD',
                    'numericKey' => 148,
                    'country' => 'Chad',
                ],
            'TF' =>
                [
                    'isoAlphaTwo' => 'TF',
                    'isoAlphaThree' => 'ATF',
                    'numericKey' => 260,
                    'country' => 'French Southern Territories',
                ],
            'TG' =>
                [
                    'isoAlphaTwo' => 'TG',
                    'isoAlphaThree' => 'TGO',
                    'numericKey' => 768,
                    'country' => 'Togo',
                ],
            'TH' =>
                [
                    'isoAlphaTwo' => 'TH',
                    'isoAlphaThree' => 'THA',
                    'numericKey' => 764,
                    'country' => 'Thailand',
                ],
            'TJ' =>
                [
                    'isoAlphaTwo' => 'TJ',
                    'isoAlphaThree' => 'TJK',
                    'numericKey' => 762,
                    'country' => 'Tajikistan',
                ],
            'TK' =>
                [
                    'isoAlphaTwo' => 'TK',
                    'isoAlphaThree' => 'TKL',
                    'numericKey' => 772,
                    'country' => 'Tokelau',
                ],
            'TL' =>
                [
                    'isoAlphaTwo' => 'TL',
                    'isoAlphaThree' => 'TLS',
                    'numericKey' => 626,
                    'country' => 'Timor-Leste',
                ],
            'TM' =>
                [
                    'isoAlphaTwo' => 'TM',
                    'isoAlphaThree' => 'TKM',
                    'numericKey' => 795,
                    'country' => 'Turkmenistan',
                ],
            'TN' =>
                [
                    'isoAlphaTwo' => 'TN',
                    'isoAlphaThree' => 'TUN',
                    'numericKey' => 788,
                    'country' => 'Tunisia',
                ],
            'TO' =>
                [
                    'isoAlphaTwo' => 'TO',
                    'isoAlphaThree' => 'TON',
                    'numericKey' => 776,
                    'country' => 'Tonga',
                ],
            'TR' =>
                [
                    'isoAlphaTwo' => 'TR',
                    'isoAlphaThree' => 'TUR',
                    'numericKey' => 792,
                    'country' => 'Turkey',
                ],
            'TT' =>
                [
                    'isoAlphaTwo' => 'TT',
                    'isoAlphaThree' => 'TTO',
                    'numericKey' => 780,
                    'country' => 'Trinidad and Tobago',
                ],
            'TV' =>
                [
                    'isoAlphaTwo' => 'TV',
                    'isoAlphaThree' => 'TUV',
                    'numericKey' => 798,
                    'country' => 'Tuvalu',
                ],
            'TW' =>
                [
                    'isoAlphaTwo' => 'TW',
                    'isoAlphaThree' => 'TWN',
                    'numericKey' => 158,
                    'country' => 'Taiwan, Province of China',
                ],
            'TZ' =>
                [
                    'isoAlphaTwo' => 'TZ',
                    'isoAlphaThree' => 'TZA',
                    'numericKey' => 834,
                    'country' => 'Tanzania, United Republic of',
                ],
            'UA' =>
                [
                    'isoAlphaTwo' => 'UA',
                    'isoAlphaThree' => 'UKR',
                    'numericKey' => 804,
                    'country' => 'Ukraine',
                ],
            'UG' =>
                [
                    'isoAlphaTwo' => 'UG',
                    'isoAlphaThree' => 'UGA',
                    'numericKey' => 800,
                    'country' => 'Uganda',
                ],
            'UM' =>
                [
                    'isoAlphaTwo' => 'UM',
                    'isoAlphaThree' => 'UMI',
                    'numericKey' => 581,
                    'country' => 'United States Minor Outlying Islands',
                ],
            'US' =>
                [
                    'isoAlphaTwo' => 'US',
                    'isoAlphaThree' => 'USA',
                    'numericKey' => 840,
                    'country' => 'United States of America',
                ],
            'UY' =>
                [
                    'isoAlphaTwo' => 'UY',
                    'isoAlphaThree' => 'URY',
                    'numericKey' => 858,
                    'country' => 'Uruguay',
                ],
            'UZ' =>
                [
                    'isoAlphaTwo' => 'UZ',
                    'isoAlphaThree' => 'UZB',
                    'numericKey' => 860,
                    'country' => 'Uzbekistan',
                ],
            'VA' =>
                [
                    'isoAlphaTwo' => 'VA',
                    'isoAlphaThree' => 'VAT',
                    'numericKey' => 336,
                    'country' => 'Holy See',
                ],
            'VC' =>
                [
                    'isoAlphaTwo' => 'VC',
                    'isoAlphaThree' => 'VCT',
                    'numericKey' => 670,
                    'country' => 'Saint Vincent and the Grenadines',
                ],
            'VE' =>
                [
                    'isoAlphaTwo' => 'VE',
                    'isoAlphaThree' => 'VEN',
                    'numericKey' => 862,
                    'country' => 'Venezuela, Bolivarian Republic of',
                ],
            'VG' =>
                [
                    'isoAlphaTwo' => 'VG',
                    'isoAlphaThree' => 'VGB',
                    'numericKey' => '092',
                    'country' => 'Virgin Islands, British',
                ],
            'VI' =>
                [
                    'isoAlphaTwo' => 'VI',
                    'isoAlphaThree' => 'VIR',
                    'numericKey' => 850,
                    'country' => 'Virgin Islands, U.S.',
                ],
            'VN' =>
                [
                    'isoAlphaTwo' => 'VN',
                    'isoAlphaThree' => 'VNM',
                    'numericKey' => 704,
                    'country' => 'Viet Nam',
                ],
            'VU' =>
                [
                    'isoAlphaTwo' => 'VU',
                    'isoAlphaThree' => 'VUT',
                    'numericKey' => 548,
                    'country' => 'Vanuatu',
                ],
            'WF' =>
                [
                    'isoAlphaTwo' => 'WF',
                    'isoAlphaThree' => 'WLF',
                    'numericKey' => 876,
                    'country' => 'Wallis and Futuna',
                ],
            'WS' =>
                [
                    'isoAlphaTwo' => 'WS',
                    'isoAlphaThree' => 'WSM',
                    'numericKey' => 882,
                    'country' => 'Samoa',
                ],
            'YE' =>
                [
                    'isoAlphaTwo' => 'YE',
                    'isoAlphaThree' => 'YEM',
                    'numericKey' => 887,
                    'country' => 'Yemen',
                ],
            'YT' =>
                [
                    'isoAlphaTwo' => 'YT',
                    'isoAlphaThree' => 'MYT',
                    'numericKey' => 175,
                    'country' => 'Mayotte',
                ],
            'ZA' =>
                [
                    'isoAlphaTwo' => 'ZA',
                    'isoAlphaThree' => 'ZAF',
                    'numericKey' => 710,
                    'country' => 'South Africa',
                ],
            'ZM' =>
                [
                    'isoAlphaTwo' => 'ZM',
                    'isoAlphaThree' => 'ZMB',
                    'numericKey' => 894,
                    'country' => 'Zambia',
                ],
            'ZW' =>
                [
                    'isoAlphaTwo' => 'ZW',
                    'isoAlphaThree' => 'ZWE',
                    'numericKey' => 716,
                    'country' => 'Zimbabwe',
                ],
        ];

        $i = 0;
        foreach($countries as $key => &$country) {
            $country['id'] = ++$i;
            $uuid = Uuid::v4();
            $country['uuid'] = $uuid->__toString();

            $this->addSql('INSERT INTO country (id, uuid, iso_alpha_two, iso_alpha_three, iso_numeric, name) VALUES (:id, :uuid, :isoAlphaTwo, :isoAlphaThree, :numericKey, :country)', $country);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE country');
    }
}
