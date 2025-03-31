<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331104151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracking_currency_pair (id INT AUTO_INCREMENT NOT NULL, base_currency VARCHAR(3) NOT NULL, target_currency VARCHAR(3) NOT NULL, error VARCHAR(255) DEFAULT NULL, is_tracked TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX isTracked_index (is_tracked), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tracking_result (id INT AUTO_INCREMENT NOT NULL, tracking_currency_pair_id INT DEFAULT NULL, rate DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BBE6425F89F9E74 (tracking_currency_pair_id), INDEX create_at_index (tracking_currency_pair_id, created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracking_result ADD CONSTRAINT FK_BBE6425F89F9E74 FOREIGN KEY (tracking_currency_pair_id) REFERENCES tracking_currency_pair (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracking_result DROP FOREIGN KEY FK_BBE6425F89F9E74');
        $this->addSql('DROP TABLE tracking_currency_pair');
        $this->addSql('DROP TABLE tracking_result');
    }
}
