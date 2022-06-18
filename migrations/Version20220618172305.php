<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220618172305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banner (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            path VARCHAR(255) NOT NULL, 
            active TINYINT(1) NOT NULL DEFAULT true,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE about_my_work_banner (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            path VARCHAR(255) NOT NULL, 
            active TINYINT(1) NOT NULL DEFAULT true,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
       $this->addSql('DROP TABLE banner');
       $this->addSql('DROP TABLE about_my_work_banner');
    }
}
