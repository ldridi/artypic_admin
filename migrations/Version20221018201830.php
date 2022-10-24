<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018201830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, response LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` CHANGE day_from day_from VARCHAR(255) NOT NULL, CHANGE day_to day_to VARCHAR(255) NOT NULL, CHANGE hour_from hour_from VARCHAR(255) NOT NULL, CHANGE hour_to hour_to VARCHAR(255) NOT NULL, CHANGE day_closed day_closed VARCHAR(255) NOT NULL, CHANGE hour_closed hour_closed VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP company_name, DROP company_adresse, DROP company_city, DROP company_zipcode, DROP company_country, DROP company_email, DROP company_phone, DROP company_tel, DROP image, DROP day_from, DROP day_to, DROP hour_from, DROP hour_to, DROP day_closed, DROP hour_closed');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE faq');
        $this->addSql('ALTER TABLE `admin` CHANGE day_from day_from VARCHAR(255) DEFAULT NULL, CHANGE day_to day_to VARCHAR(255) DEFAULT NULL, CHANGE hour_from hour_from VARCHAR(255) DEFAULT NULL, CHANGE hour_to hour_to VARCHAR(255) DEFAULT NULL, CHANGE day_closed day_closed VARCHAR(255) DEFAULT NULL, CHANGE hour_closed hour_closed VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD company_name VARCHAR(255) DEFAULT NULL, ADD company_adresse VARCHAR(255) DEFAULT NULL, ADD company_city VARCHAR(255) DEFAULT NULL, ADD company_zipcode VARCHAR(255) DEFAULT NULL, ADD company_country VARCHAR(255) DEFAULT NULL, ADD company_email VARCHAR(255) DEFAULT NULL, ADD company_phone VARCHAR(255) DEFAULT NULL, ADD company_tel VARCHAR(255) DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL, ADD day_from VARCHAR(255) NOT NULL, ADD day_to VARCHAR(255) NOT NULL, ADD hour_from VARCHAR(255) NOT NULL, ADD hour_to VARCHAR(255) NOT NULL, ADD day_closed VARCHAR(255) NOT NULL, ADD hour_closed VARCHAR(255) NOT NULL');
    }
}
