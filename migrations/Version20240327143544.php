<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327143544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE society (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, rccm_id INT DEFAULT NULL, certificate_id INT DEFAULT NULL, calling_card_id INT DEFAULT NULL, pv_id INT DEFAULT NULL, form_id INT DEFAULT NULL, expense_report_id INT DEFAULT NULL, proof_of_payment_id INT DEFAULT NULL, type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, trade_name VARCHAR(255) DEFAULT NULL, INDEX IDX_D6461F2E946114A (province_id), UNIQUE INDEX UNIQ_D6461F2E6255DE9 (rccm_id), UNIQUE INDEX UNIQ_D6461F299223FFD (certificate_id), UNIQUE INDEX UNIQ_D6461F2AB40D429 (calling_card_id), UNIQUE INDEX UNIQ_D6461F2E8A4F4B0 (pv_id), UNIQUE INDEX UNIQ_D6461F25FF69B7D (form_id), UNIQUE INDEX UNIQ_D6461F28F758FBA (expense_report_id), UNIQUE INDEX UNIQ_D6461F29F0ED322 (proof_of_payment_id), INDEX IDX_D6461F2C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE society_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2E6255DE9 FOREIGN KEY (rccm_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F299223FFD FOREIGN KEY (certificate_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2AB40D429 FOREIGN KEY (calling_card_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2E8A4F4B0 FOREIGN KEY (pv_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F25FF69B7D FOREIGN KEY (form_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F28F758FBA FOREIGN KEY (expense_report_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F29F0ED322 FOREIGN KEY (proof_of_payment_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2C54C8C93 FOREIGN KEY (type_id) REFERENCES society_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2E946114A');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2E6255DE9');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F299223FFD');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2AB40D429');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2E8A4F4B0');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F25FF69B7D');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F28F758FBA');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F29F0ED322');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2C54C8C93');
        $this->addSql('DROP TABLE society');
        $this->addSql('DROP TABLE society_type');
    }
}
