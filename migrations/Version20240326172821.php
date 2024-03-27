<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326172821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salary (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, year_id INT DEFAULT NULL, base_amount NUMERIC(10, 6) NOT NULL, risk_premium_amount NUMERIC(10, 6) DEFAULT NULL, function_bonus_amount NUMERIC(10, 6) DEFAULT NULL, month VARCHAR(2) NOT NULL, INDEX IDX_9413BB713414710B (agent_id), INDEX IDX_9413BB7140C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salary ADD CONSTRAINT FK_9413BB713414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE salary ADD CONSTRAINT FK_9413BB7140C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE agent ADD province_id INT DEFAULT NULL, ADD conjoint_origin LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('CREATE INDEX IDX_268B9C9DE946114A ON agent (province_id)');
        $this->addSql('ALTER TABLE assignment ADD year_id INT DEFAULT NULL, ADD province_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('CREATE INDEX IDX_30C544BA40C1FEA7 ON assignment (year_id)');
        $this->addSql('CREATE INDEX IDX_30C544BAE946114A ON assignment (province_id)');
        $this->addSql('ALTER TABLE expense ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA640C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_2D3A8DA640C1FEA7 ON expense (year_id)');
        $this->addSql('ALTER TABLE medical ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075A40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_77DB075A40C1FEA7 ON medical (year_id)');
        $this->addSql('ALTER TABLE mission ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C40C1FEA7 ON mission (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salary DROP FOREIGN KEY FK_9413BB713414710B');
        $this->addSql('ALTER TABLE salary DROP FOREIGN KEY FK_9413BB7140C1FEA7');
        $this->addSql('DROP TABLE salary');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DE946114A');
        $this->addSql('DROP INDEX IDX_268B9C9DE946114A ON agent');
        $this->addSql('ALTER TABLE agent DROP province_id, DROP conjoint_origin');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA40C1FEA7');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAE946114A');
        $this->addSql('DROP INDEX IDX_30C544BA40C1FEA7 ON assignment');
        $this->addSql('DROP INDEX IDX_30C544BAE946114A ON assignment');
        $this->addSql('ALTER TABLE assignment DROP year_id, DROP province_id');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA640C1FEA7');
        $this->addSql('DROP INDEX IDX_2D3A8DA640C1FEA7 ON expense');
        $this->addSql('ALTER TABLE expense DROP year_id');
        $this->addSql('ALTER TABLE medical DROP FOREIGN KEY FK_77DB075A40C1FEA7');
        $this->addSql('DROP INDEX IDX_77DB075A40C1FEA7 ON medical');
        $this->addSql('ALTER TABLE medical DROP year_id');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C40C1FEA7');
        $this->addSql('DROP INDEX IDX_9067F23C40C1FEA7 ON mission');
        $this->addSql('ALTER TABLE mission DROP year_id');
    }
}
