<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018133342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` CHANGE day_from day_from VARCHAR(255) NOT NULL, CHANGE day_to day_to VARCHAR(255) NOT NULL, CHANGE hour_from hour_from VARCHAR(255) NOT NULL, CHANGE hour_to hour_to VARCHAR(255) NOT NULL, CHANGE day_closed day_closed VARCHAR(255) NOT NULL, CHANGE hour_closed hour_closed VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD989D9B62 ON product (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` CHANGE day_from day_from VARCHAR(255) DEFAULT NULL, CHANGE day_to day_to VARCHAR(255) DEFAULT NULL, CHANGE hour_from hour_from VARCHAR(255) DEFAULT NULL, CHANGE hour_to hour_to VARCHAR(255) DEFAULT NULL, CHANGE day_closed day_closed VARCHAR(255) DEFAULT NULL, CHANGE hour_closed hour_closed VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_D34A04AD989D9B62 ON product');
    }
}
