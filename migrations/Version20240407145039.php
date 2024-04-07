<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407145039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salary CHANGE base_amount base_amount NUMERIC(20, 2) NOT NULL, CHANGE risk_premium_amount risk_premium_amount NUMERIC(20, 2) DEFAULT NULL, CHANGE function_bonus_amount function_bonus_amount NUMERIC(20, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salary CHANGE base_amount base_amount NUMERIC(11, 2) NOT NULL, CHANGE risk_premium_amount risk_premium_amount NUMERIC(11, 2) DEFAULT NULL, CHANGE function_bonus_amount function_bonus_amount NUMERIC(11, 2) DEFAULT NULL');
    }
}
