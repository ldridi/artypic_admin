<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018130652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP company_name, DROP company_adresse, DROP company_city, DROP company_zipcode, DROP company_country, DROP company_email, DROP company_phone, DROP company_tel, DROP day_from, DROP day_to, DROP hour_from, DROP hour_to, DROP day_closed, DROP hour_closed, DROP image');
        $this->addSql('ALTER TABLE user ADD company_name VARCHAR(255) DEFAULT NULL, ADD company_adresse VARCHAR(255) DEFAULT NULL, ADD company_city VARCHAR(255) DEFAULT NULL, ADD company_zipcode VARCHAR(255) DEFAULT NULL, ADD company_country VARCHAR(255) DEFAULT NULL, ADD company_email VARCHAR(255) DEFAULT NULL, ADD company_phone VARCHAR(255) DEFAULT NULL, ADD company_tel VARCHAR(255) DEFAULT NULL, ADD day_from VARCHAR(255) NOT NULL, ADD day_to VARCHAR(255) NOT NULL, ADD hour_from VARCHAR(255) NOT NULL, ADD hour_to VARCHAR(255) NOT NULL, ADD day_closed VARCHAR(255) NOT NULL, ADD hour_closed VARCHAR(255) NOT NULL, ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` ADD company_name VARCHAR(255) DEFAULT NULL, ADD company_adresse VARCHAR(255) DEFAULT NULL, ADD company_city VARCHAR(255) DEFAULT NULL, ADD company_zipcode VARCHAR(255) DEFAULT NULL, ADD company_country VARCHAR(255) DEFAULT NULL, ADD company_email VARCHAR(255) DEFAULT NULL, ADD company_phone VARCHAR(255) DEFAULT NULL, ADD company_tel VARCHAR(255) DEFAULT NULL, ADD day_from VARCHAR(255) DEFAULT NULL, ADD day_to VARCHAR(255) DEFAULT NULL, ADD hour_from VARCHAR(255) DEFAULT NULL, ADD hour_to VARCHAR(255) DEFAULT NULL, ADD day_closed VARCHAR(255) DEFAULT NULL, ADD hour_closed VARCHAR(255) DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP company_name, DROP company_adresse, DROP company_city, DROP company_zipcode, DROP company_country, DROP company_email, DROP company_phone, DROP company_tel, DROP day_from, DROP day_to, DROP hour_from, DROP hour_to, DROP day_closed, DROP hour_closed, DROP image');
    }
}
