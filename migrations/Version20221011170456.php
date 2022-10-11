<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011170456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD is_verified TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON `admin` (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_880E0D76E7927C74 ON `admin`');
        $this->addSql('ALTER TABLE `admin` DROP email, DROP roles, DROP password, DROP is_verified');
    }
}
