<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327155530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE society_recovery (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, type_id INT DEFAULT NULL, society_id INT DEFAULT NULL, certificate_id INT DEFAULT NULL, calling_card_id INT DEFAULT NULL, pv_id INT DEFAULT NULL, form_id INT DEFAULT NULL, expense_report_id INT DEFAULT NULL, proof_of_payment_id INT DEFAULT NULL, province_id INT DEFAULT NULL, is_completed TINYINT(1) NOT NULL, released_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_BAA5E6B83414710B (agent_id), INDEX IDX_BAA5E6B8C54C8C93 (type_id), INDEX IDX_BAA5E6B8E6389D24 (society_id), UNIQUE INDEX UNIQ_BAA5E6B899223FFD (certificate_id), UNIQUE INDEX UNIQ_BAA5E6B8AB40D429 (calling_card_id), UNIQUE INDEX UNIQ_BAA5E6B8E8A4F4B0 (pv_id), UNIQUE INDEX UNIQ_BAA5E6B85FF69B7D (form_id), UNIQUE INDEX UNIQ_BAA5E6B88F758FBA (expense_report_id), UNIQUE INDEX UNIQ_BAA5E6B89F0ED322 (proof_of_payment_id), INDEX IDX_BAA5E6B8E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B83414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8C54C8C93 FOREIGN KEY (type_id) REFERENCES society_type (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8E6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B899223FFD FOREIGN KEY (certificate_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8AB40D429 FOREIGN KEY (calling_card_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8E8A4F4B0 FOREIGN KEY (pv_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B85FF69B7D FOREIGN KEY (form_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B88F758FBA FOREIGN KEY (expense_report_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B89F0ED322 FOREIGN KEY (proof_of_payment_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F25FF69B7D');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F28F758FBA');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F299223FFD');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F29F0ED322');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2AB40D429');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2E8A4F4B0');
        $this->addSql('DROP INDEX UNIQ_D6461F25FF69B7D ON society');
        $this->addSql('DROP INDEX UNIQ_D6461F28F758FBA ON society');
        $this->addSql('DROP INDEX UNIQ_D6461F299223FFD ON society');
        $this->addSql('DROP INDEX UNIQ_D6461F29F0ED322 ON society');
        $this->addSql('DROP INDEX UNIQ_D6461F2AB40D429 ON society');
        $this->addSql('DROP INDEX UNIQ_D6461F2E8A4F4B0 ON society');
        $this->addSql('ALTER TABLE society ADD is_deleted TINYINT(1) DEFAULT NULL, DROP certificate_id, DROP calling_card_id, DROP pv_id, DROP form_id, DROP expense_report_id, DROP proof_of_payment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B83414710B');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8C54C8C93');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8E6389D24');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B899223FFD');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8AB40D429');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8E8A4F4B0');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B85FF69B7D');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B88F758FBA');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B89F0ED322');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8E946114A');
        $this->addSql('DROP TABLE society_recovery');
        $this->addSql('ALTER TABLE society ADD certificate_id INT DEFAULT NULL, ADD calling_card_id INT DEFAULT NULL, ADD pv_id INT DEFAULT NULL, ADD form_id INT DEFAULT NULL, ADD expense_report_id INT DEFAULT NULL, ADD proof_of_payment_id INT DEFAULT NULL, DROP is_deleted');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F25FF69B7D FOREIGN KEY (form_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F28F758FBA FOREIGN KEY (expense_report_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F299223FFD FOREIGN KEY (certificate_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F29F0ED322 FOREIGN KEY (proof_of_payment_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2AB40D429 FOREIGN KEY (calling_card_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2E8A4F4B0 FOREIGN KEY (pv_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6461F25FF69B7D ON society (form_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6461F28F758FBA ON society (expense_report_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6461F299223FFD ON society (certificate_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6461F29F0ED322 ON society (proof_of_payment_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6461F2AB40D429 ON society (calling_card_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6461F2E8A4F4B0 ON society (pv_id)');
    }
}
