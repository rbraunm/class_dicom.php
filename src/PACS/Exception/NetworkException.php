<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Exception;

/**
 * A DICOM network operation failed: the peer could not be reached, the association
 * was rejected, a timeout elapsed, or the DIMSE exchange (C-ECHO, C-STORE) was
 * unsuccessful. The wrapped DCMTK tool's exit code and message are included.
 */
class NetworkException extends \RuntimeException implements ExceptionInterface
{
}
