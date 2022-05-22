<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411200008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_items (
        `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
        `item_name` VARCHAR(255) NOT NULL,
        `item_link` VARCHAR(255) NOT NULL, 
        `active` TINYINT(1) DEFAULT \'1\' NOT NULL,
        `item_order` TINYINT(1) DEFAULT 0 NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY(id)) 
        DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `menu_items`');
    }
}
